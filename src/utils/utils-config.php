<?php

include_once dirname(__FILE__) . '/../utils/utils-db.php';

function set_database_config($name, $value)
{
    $req = "UPDATE config SET value = '$value' WHERE name = '$name'";
    $res = db_ask($req);
    if ($res == true)
        return true;
    else
        return false;
}

function get_database_config($name)
{
    $req = "SELECT value FROM config WHERE name = '$name'";
    $res = db_ask($req);
    return $res[0]["value"];
}

?>