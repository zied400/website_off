<?php

class nsc_bar_save_form_fields
{
    private $plugin_settings;
    private $banner_configs_obj;
    private $plugin_configs;

    public function __construct()
    {
        $this->plugin_configs = new nsc_bar_plugin_configs();
        $this->plugin_settings = $this->plugin_configs->nsc_bar_return_plugin_settings_without_db_settings();
        $this->banner_configs_obj = new nsc_bar_banner_configs();
    }

    public function nsc_bar_save_submitted_form_fields()
    {

        $updated = $this->save_settings(null);
        $saved_language_configs = $this->banner_configs_obj->nsc_bar_get_banner_config_array();
        $this->override_other_addon_configs($updated, $saved_language_configs);
        //needed for testing
        return $saved_language_configs;
    }

    private function save_settings($addon_settings)
    {
        $tabs = $this->plugin_settings->setting_page_fields->tabs;
        $plugin_prefix = $this->plugin_settings->plugin_prefix;
        $validate = new nsc_bar_input_validation;
        $banner_settings_updated = false;
        $configs_updated = false;

        foreach ($tabs as $tab_index => $tab) {
            foreach ($tab->tabfields as $tabfield_index => $tabfield) {
                $tabfield_slug = $plugin_prefix . $tabfield->field_slug;
                $manager_string = $this->value_save_manager($tabfield, $tabfield_slug, $addon_settings);
                if ($manager_string === "update_banner") {
                    $post_value = isset($_POST[$tabfield_slug]) ? $_POST[$tabfield_slug] : $_POST[$tabfield_slug . "_hidden"];
                    $new_value = $validate->nsc_bar_validate_field_custom_save($tabfield->extra_validation_name, $post_value);
                    $this->banner_configs_obj->nsc_bar_update_banner_setting($tabfield->field_slug, $new_value, $tabfield->save_as);
                    $banner_settings_updated = true;
                }

                if ($manager_string === "update_wp_option") {
                    $post_value = isset($_POST[$tabfield_slug]) ? $_POST[$tabfield_slug] : $_POST[$tabfield_slug . "_hidden"];
                    $new_value = $validate->nsc_bar_validate_field_custom_save($tabfield->extra_validation_name, $post_value);
                    $this->plugin_configs->nsc_bar_update_option($tabfield->field_slug, $new_value);
                    $configs_updated = true;
                }
            }
        }

        if ($banner_settings_updated) {
            $this->banner_configs_obj->nsc_bar_save_banner_settings();
        }

        $validate->return_errors_obj()->nsc_bar_display_errors();

        if ($banner_settings_updated === true || $configs_updated === true) {
            return true;
        }
        return false;
    }

    private function override_other_addon_configs($updated, $saved_language_configs)
    {
        if (class_exists("nsc_bara_save_form_fields_addon") !== true) {
            return false;
        }

        $bara = new nsc_bara_save_form_fields_addon;
        if ($bara->nsc_bara_must_i_save_other_languages($updated) !== true) {
            return false;
        }

        $bara_banner_configs = new nsc_bara_banner_configs_addon;
        $language_configs = $bara->nsc_bara_get_all_languages_configs($saved_language_configs);
        foreach ($language_configs as $lang => $language_config) {
            $addon_settings = $bara->nsc_bara_get_addon_settings("override", $lang);
            $this->banner_configs_obj->nsc_bar_set_banner_config_array($language_config);
            // to know where to save
            $this->banner_configs_obj->nsc_bar_set_banner_configs_slug($bara_banner_configs->nsc_bara_get_banner_settings_slug($addon_settings));
            $this->save_settings($addon_settings);
        }

    }

    private function value_save_manager($tabfield, $tabfield_slug, $addon_settings)
    {
        if (
            $tabfield->save_in_db === false &&
            $this->save_field_with_data_from_post($tabfield, $addon_settings) &&
            (isset($_POST[$tabfield_slug]) || isset($_POST[$tabfield_slug . "_hidden"]))
        ) {
            return "update_banner";
        }

        if (
            $tabfield->save_in_db === true &&
            $this->save_field_with_data_from_post($tabfield, $addon_settings) &&
            (isset($_POST[$tabfield_slug]) || isset($_POST[$tabfield_slug . "_hidden"]))
        ) {
            return "update_wp_option";
        }
        return "skip";
    }

    private function save_field_with_data_from_post($tabfield, $addon_settings)
    {
        if (class_exists("nsc_bara_save_form_fields_addon") === true) {
            $save_fields_addon = new nsc_bara_save_form_fields_addon();
            return $save_fields_addon->nsc_bara_save_field_with_data_from_post($tabfield, $addon_settings);
        }
        return true;
    }

}
