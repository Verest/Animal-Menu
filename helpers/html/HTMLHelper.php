<?php

namespace AnimalMenu\Helpers\Html;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use AnimalMenu\Helpers\Options;

abstract class HTMLHelper
{
    protected static function getSanitizedOptionValue($id)
    {
        $options = Options::get();

        return isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
    }
}