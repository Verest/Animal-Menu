<?php

namespace AnimalMenu\Helpers\Html;

// exit if file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use AnimalMenu\Helpers\Config;

class SettingsHTML extends HTMLHelper
{
    public static function adminSettings()
    {
        ?>
        <div class="wrap">
            <h1>
                <?php echo esc_html(get_admin_page_title()); ?>
            </h1>

            <form action="options.php" method="post">
                <?php
                settings_fields(Config::getOptionName());
                do_settings_sections(Config::getSettingsSlug());

                submit_button('Update Admin Menu');
                ?>
            </form>
        </div>
        <?php
    }

    public static function mainSettingSection()
    {
        echo "<p>Settings below will add a new section to the Admin Menu Bar.</p>";
    }
}