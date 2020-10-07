<?php

namespace AnimalMenu\Helpers;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

class Config
{
    public static function getTableName()
    {
        global $wpdb;

        return $wpdb->prefix . 'animal_menu_counter';
    }

    public static function getOptionName()
    {
        return 'animal_menu_options';
    }

    public static function getSettingsSlug()
    {
        return 'animal-page';
    }
}