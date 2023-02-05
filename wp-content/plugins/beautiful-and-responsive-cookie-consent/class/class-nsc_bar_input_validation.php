<?php

class nsc_bar_input_validation
{
    private $admin_error_obj;

    public function __construct()
    {
        $this->admin_error_obj = new nsc_bar_admin_error;
    }

    public function nsc_bar_validate_field_custom_save($extra_validation_value, $input)
    {
        $return = $this->nsc_bar_sanitize_input($input);
        switch ($extra_validation_value) {
            case "nsc_bar_check_input_color_code":
                $return = $this->nsc_bar_check_input_color_code($return);
                break;
            case "nsc_bar_check_input_json_settings":
                $return = $this->nsc_bar_check_input_json_settings($return);
                break;
            case "nsc_bar_check_valid_json_string":
                $return = $this->nsc_bar_check_valid_json_string($return);
                break;
            case "nsc_bar_check_cookietypes":
                $return = $this->nsc_bar_check_cookietypes($return);
                break;
            case "nsc_bar_replace_doublequote_with_single":
                $return = $this->nsc_bar_replace_doublequote_with_single($return);
                break;
            case "nsc_bar_integer":
                $return = $this->nsc_bar_integer($return);
                break;
            case "nsc_bara_custom_services":
                $return = $this->nsc_bar_bara_custom_services($return);
                break;
        }
        $return = apply_filters('nsc_bar_filter_input_validation', $return, $extra_validation_value);
        return $return;
    }

    public function nsc_bar_sanitize_input($input)
    {
        $cleandValue = stripslashes($input);
        return sanitize_text_field($cleandValue);
    }

    public function nsc_bar_bara_custom_services($input)
    {

        $testedJson = $this->nsc_bar_check_valid_json_string($input);
        if (empty($testedJson)) {
            return null;
        }

        if (class_exists("nsc_bara_input_validation")) {
            $bara_validation = new nsc_bara_input_validation;
            return $bara_validation->nsc_bara_custom_services($testedJson);
        }
        return null;
    }

    public function nsc_bar_integer($input)
    {
        $valid = preg_match("/^[0-9]*$/", $input);
        if (empty($valid) && $input != "") {
            $this->admin_error_obj->nsc_bar_set_admin_error("Number could not be saved. Please provide an integer. Your input: " . $input);
            $input = "";
        }
        $this->admin_error_obj->nsc_bar_display_errors();
        return $input;
    }

    public function nsc_bar_check_input_color_code($input)
    {
        return $input;
    }

    public function nsc_bar_replace_doublequote_with_single($input)
    {
        return str_replace(['"', "\""], "'", $input);
    }

    public function nsc_bar_check_valid_json_string($json_string)
    {
        if ($json_string == "1") {
            return null;
        }

        $php_version_good = $this->php_version_good();
        switch ($php_version_good) {
            case true:
                $tested_json_string = json_encode(json_decode($json_string), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            default:
                $tested_json_string = json_encode(json_decode($json_string));
                break;
        }

        if (empty($tested_json_string) || $tested_json_string == "null") {
            $this->admin_error_obj->nsc_bar_set_admin_error("Please provide a valid json string. Data was not saved.");
            return null;
        } else {
            return $tested_json_string;
        }
    }

    public function php_version_good($minVersion = '5.4.0')
    {
        if (version_compare(phpversion(), $minVersion, '>=')) {
            return true;
        } else {
            return false;
        }
    }

    public function nsc_bar_check_cookietypes($input)
    {
        //should be an impossible case, because default settings have cookie types and the frontend js makes it impossible to delete all cookie types.
        if (empty($input)) {
            //$this->admin_error_obj->nsc_bar_set_admin_error("Please provide at least one cookie type.");
            //$this->admin_error_obj->nsc_bar_display_errors();
            //TODO: if all installation are >= v2.0 change this line to "return null" and uncomment lines above.
            $input = '[{"label": "Technical","checked": "checked","disabled":"disabled","cookie_suffix":"tech"}]';
        }

        $valid = $this->nsc_bar_check_valid_json_string($input);
        if (empty($valid)) {
            $this->admin_error_obj->nsc_bar_display_errors();
            return $this->get_old_cookietype_value();
        }

        $arr_cookietypes = json_decode($valid, true);
        foreach ($arr_cookietypes as $arr_cookietype) {
            if (preg_match('/^[a-z_]+$/', $arr_cookietype["cookie_suffix"]) === 0) {
                $this->admin_error_obj->nsc_bar_set_admin_error("Cookie suffix must be only lowercase letter and underscores.");
                return $this->get_old_cookietype_value();
            }
            if (strlen($arr_cookietype["cookie_suffix"]) > 10) {
                $this->admin_error_obj->nsc_bar_set_admin_error("Cookie suffix must only have ten characters.");
                return $this->get_old_cookietype_value();
            }
        }
        return $valid;
    }

    private function get_old_cookietype_value()
    {
        $banner_configs = new nsc_bar_banner_configs;
        $banner_config_array = $banner_configs->nsc_bar_get_banner_config_array();
        $old_value = null;
        if (isset($banner_config_array["cookietypes"])) {
            $old_value = json_encode($banner_config_array["cookietypes"]);
        }
        return $old_value;
    }

    public function nsc_bar_check_input_json_settings($input)
    {
        $valid = $this->nsc_bar_check_valid_json_string($input);
        if (empty($valid)) {
            $banner_configs = new nsc_bar_banner_configs;
            $old_value = $banner_configs->nsc_bar_get_banner_config_string();
            $this->admin_error_obj->nsc_bar_display_errors();
            return $old_value;
        }
        return $input;
    }

    public function esc_array_for_js($array_to_escape)
    {
        $escapedArray = array();
        foreach ($array_to_escape as $key => $value) {
            $escKey = esc_js($key);
            if (!is_array($value)) {
                $escValue = esc_js($value);
                $escapedArray[$escKey] = $escValue;
            }

            if (is_array($value)) {
                foreach ($value as $key_of_v => $value_of_v) {
                    $escKey_v = esc_js($key_of_v);
                    $escValue_v = esc_js($value_of_v);
                    $escapedArray[$escKey][$escKey_v] = $escValue_v;
                }
            }
        }
        return $escapedArray;
    }

    public function return_errors_obj()
    {
        return $this->admin_error_obj;
    }

}
