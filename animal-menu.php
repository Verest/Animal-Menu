<?php

namespace AnimalMenu;

use AnimalMenu\Admin\AdminMenu;
use AnimalMenu\Admin\AnimalMenu;

/**
 * Plugin Name:  Animal Menu
 * Description:  Simple Plugin that adds an Admin Menu Item
 * Requires PHP: 5.6
 * Author:       Richie Black
 * Text Domain:  animal-menu
 * License:      GPLv2 or later
 */


// Exit if called directly.
if (!defined('ABSPATH')) {
    exit;
}

include_once "includes/autoload.php";

register_activation_hook( __FILE__, [AnimalMenu::class, 'install']);
register_uninstall_hook( __FILE__, [AnimalMenu::class, 'uninstall']);

if (is_admin()) {
    AdminMenu::initialize();
    AnimalMenu::initialize();
}
