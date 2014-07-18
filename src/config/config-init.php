<?php
/**
 * This is the CONFIG file for Monitoring project.
 * Please set your credentials.
 * Make sure permissions is set to 0644 or 0444 and
 * forbid the access by use of .htaccess or apache configurations.
 */

// Let's begin with setup.ini
$toDefine = parse_ini_file(CONFIG_DIR . 'setup.ini', true);

__config_define($toDefine, "directories");
__config_define($toDefine, "files");

// Now we can define variables for admin config
$toDefine = parse_ini_file(ADMIN_CONFIG_PATH, true);

__config_define($toDefine, "database");
__config_define($toDefine, "superadmin");
__config_define($toDefine, "control");

// FUNCTIONS

function __config_define($array, $identifier)
{
    $object = $array[$identifier];
    $keys = array_keys($object);
    for ($i=0; $i < count($keys); $i++)
    {
        $key = $keys[$i];
        define(strtoupper($keys[$i]), $object[$key]);
    }
}

?>
