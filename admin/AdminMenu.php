<?php

namespace AnimalMenu\Admin;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use AnimalMenu\Helpers\Config;
use AnimalMenu\Helpers\Options;
use AnimalMenu\Helpers\Html\FormHTML;
use AnimalMenu\Helpers\Html\SettingsHTML;

class AdminMenu
{
    public static function initialize()
    {
        add_action('admin_menu', [self::class, 'addSubMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
    }

    public static function addSubMenu()
    {
        add_submenu_page(
            'options-general.php',
            'Animal Menu Settings',
            'Animal Menu',
            'manage_options',
            Config::getSettingsSlug(),
            [SettingsHTML::class, 'adminSettings']
        );
    }

    public static function registerSettings()
    {
        register_setting(
            Config::getOptionName(),
            Config::getOptionName(),
            [self::class, 'validate']
        );

        add_settings_section(
            'animal_menu_section_main',
            '',
            [SettingsHTML::class, 'mainSettingSection'],
            Config::getSettingsSlug()
        );

        add_settings_field(
            'custom_admin_menu_type',
            'Animal Type',
            [FormHTML::class, 'selectField'],
            Config::getSettingsSlug(),
            'animal_menu_section_main',
            [ 'id' => 'animal_type', 'label' => 'Choose an animal type...' ]
        );

        add_settings_field(
            'custom_admin_menu_text',
            'Menu Bar Text',
            [FormHTML::class, 'textField'],
            Config::getSettingsSlug(),
            'animal_menu_section_main',
            [ 'id' => 'menu_title', 'label' => 'Choose Menu Bar Text...' ]
        );
    }

    public static function validate($input)
    {
        $validAnimalTypes = Options::getPermittedAnimals();

        $animalType =& $input['animal_type'];
        if (!isset($validAnimalTypes[$animalType])) {
            $animalType = Options::getDefault('animal_type');
        }

        $menuTitle =& $input['menu_title'];
        $menuTitle = sanitize_text_field($menuTitle);

        return $input;
    }
}