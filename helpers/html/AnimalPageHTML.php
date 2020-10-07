<?php

namespace AnimalMenu\Helpers\Html;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

class AnimalPageHTML extends HTMLHelper
{
    public static function render()
    {
        $pageCount = self::getPageVisitCount();
        $optionValue = ucwords(self::getSanitizedOptionValue('animal_type'));
        $echoChosenAnimal = "echo{$optionValue}Figure";

        if (is_callable(self::class . "::$echoChosenAnimal")) {
            ucwords($optionValue);

            echo "<div class='wrap'>";
            echo '<h1>Random ' . ucwords($optionValue) . ' Image!</h1>';
            echo "<p>This page has been visited: $pageCount times!</p>";
            self::$echoChosenAnimal();
            echo "</div>";
        } else {
            echo "<p>Not Yet Supported...</p>";
        }
    }

    private static function echoCatFigure()
    {
        $width = rand(400, 700);
        $height = rand(400, 700);

        echo "<figure>";
        echo "<img src='http://placekitten.com/$width/$height' alt='Cat Image'>";
        echo "<figcaption>Placeholder of a Cat!</figcaption>";
        echo "</figure>";
    }

    private static function echoDogFigure()
    {
        $width = rand(400, 700);
        $height = rand(400, 700);

        echo "<figure>";
        echo "<img src='https://placedog.net/$width/$height' alt='Dog Image'>";
        echo "<figcaption>Placeholder of a Doggo!</figcaption>";
        echo "</figure>";
    }

    private static function getPageVisitCount()
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'animal_menu_counter';;
        $count = $wpdb->get_var("SELECT page_visit_count from $tableName LIMIT 1") + 1;
        $wpdb->update($tableName, ['page_visit_count' => $count], ['id' => 1]);

        return $count;
    }
}
