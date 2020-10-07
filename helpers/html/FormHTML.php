<?php

namespace AnimalMenu\Helpers\Html;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use AnimalMenu\Helpers\Config;
use AnimalMenu\Helpers\Options;

class FormHTML extends HTMLHelper
{
    public static function selectField($args)
    {
        list($id, $label) = self::parseSettingArgs($args);
        $optionValue = self::getSanitizedOptionValue($id);
        $optionName = Config::getOptionName();

        echo "<select id='{$optionName}_$id' name='{$optionName}[$id]'>";

        $validSelectOptions = Options::getPermittedAnimals();
        foreach ($validSelectOptions as $value => $option) {
            $selected = selected($optionValue === $value, true, false );
            echo "<option value='$value' $selected>$option</option>";
        }

        echo '</select><br>';
        echo "<label for='{$optionName}_$id'>$label</label>";
    }

    public static function textField($args)
    {
        list($id, $label) = self::parseSettingArgs($args);
        $optionValue = self::getSanitizedOptionValue($id) ?: Options::getDefault($id);
        $optionName = Config::getOptionName();

        echo "<input id='{$optionName}_$id' name='{$optionName}[$id]' type='text' value='$optionValue'>";
        echo '<br>';
        echo "<label for='{$optionName}_$id'>$label</label>";
    }


    private static function parseSettingArgs($args)
    {
        $id = isset($args['id']) ? $args['id'] : '';
        $label = isset($args['label']) ? $args['label'] : '';

        return [$id, $label];
    }
}