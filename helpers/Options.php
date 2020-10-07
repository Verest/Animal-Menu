<?php

namespace AnimalMenu\Helpers;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

class Options
{
    private static $options;

    public static function get()
    {
        if (isset(self::$options)) {
            return self::$options;
        }

        return get_option(Config::getOptionName(), self::getDefaults());
    }

    public static function getDefault($setting)
    {
        $defaults = self::getDefaults();

        return isset($defaults[$setting]) ? $defaults[$setting] : null;
    }

    public static function getDefaults()
    {
        return [
            'animal_type' => '',
            'menu_title' => 'Animal Pics!'
        ];
    }

    public static function getPermittedAnimals()
    {
        return [
            '' => 'None',
            'cat' => 'Cat',
            'dog' => 'Dog'
        ];
    }
}