<?php

namespace AnimalMenu\Admin;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use AnimalMenu\Helpers\Config;
use AnimalMenu\Helpers\Options;
use AnimalMenu\Helpers\Html\AnimalPageHTML;

class AnimalMenu
{
    public static function install()
    {
        global $wpdb;

        $tableName = Config::getTableName();

        if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $tableName (
                id INT NOT NULL AUTO_INCREMENT, page_visit_count INT NOT NULL, PRIMARY KEY (id)
            ) $charset_collate;";

            $sql .= "INSERT INTO $tableName (id, page_visit_count) VALUES ('1', '0');";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    public function uninstall()
    {
        delete_option(Config::getOptionName());

        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS " . Config::getTableName());
    }

    public static function initialize()
    {
        add_action('wp_before_admin_bar_render', [self::class, 'addCustomAdminBarMenuItem'], 100);
        add_action('admin_menu', [self::class, 'addCustomPage']);
    }

    public static function addCustomAdminBarMenuItem()
    {
        $animalType =& Options::get()['animal_type'];

        if ($animalType) {
            global $wp_admin_bar;

            $customTitle =& Options::get()['menu_title'];
            $wp_admin_bar->add_menu([
                'id' => 'animal_admin_menu',
                'title' =>  esc_html($customTitle ?: Options::getDefault('menu_title')),
                'href' => admin_url('?page=view-animal'),
            ]);
        }
    }

    public static function addCustomPage()
    {
        $animalType =& Options::get()['animal_type'];
        if ($animalType) {
            $customTitle = ucwords(esc_html($animalType)) . ' Image';

            add_submenu_page(
                null,
                $customTitle,
                $customTitle,
                'read',
                "view-animal",
                [AnimalPageHTML::class, 'render']
            );
        }
    }
}