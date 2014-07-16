<?php

/* 
 * Copyright (C) 2014 Christophe
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('config/config.php');
require_once('include.php');

// Define ajax scripts.
define('QUERY_GET_FORM', 'getForm');
define('QUERY_TEST_CONTROL', 'controlTest');

define('QUERY_NONE', 'nothing');

class AjaxScript
{
    // database object
    var $pdo = null;
    // error messages
    var $error = null;

    /**
    * class constructor
    */
    function __construct()
    {
        // instantiate the pdo object
        try
        {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_AUTH_DBNAME . "";
            $this->pdo =  new PDO($dsn,DB_AUTH_USERNAME, DB_AUTH_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Check if logged.
            session_start();
            if (isset($_SESSION))
                $connected = true;

        } catch (PDOException $e)
        {
            print "Error!: " . $e->getMessage();
            die();
        }
    }
    
    function executeQuery($action, $request)
    {
        $request = $this->sanitizeRequest($_REQUEST);
        
        try
        {
            switch ($action)
            {
                case QUERY_GET_FORM:
                   $this->__obtainHTMLFormForPlugin($request["controlname"]);
                    exit(0);
                    break;
                case QUERY_TEST_CONTROL:
                    $this->__checkPluginControl($request);
                case QUERY_NONE:
                default:
                    throw new Exception("Requête inconnue");
            }
        }
        catch (Exception $e)
        {
            if (isset($origin))
            {
                header('Location: ' . $origin);
                $_SESSION["message"] = array("type" => "danger", "title" => "Erreur", "descr" => $e->getMessage());
                exit(0);
            }
            else
            {
                header('Location: ' . $_COOKIE["last-page"]);
                $_SESSION["message"] = array("type" => "danger", "title" => "Erreur", "descr" => $e->getMessage());
                exit(0);
            }
        }
    }
    
    private function __obtainHTMLFormForPlugin($pluginName)
    {
        $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
        $plugin = $pm->getPlugin($pluginName);
        $formArray = $plugin->loadForm();
        
        if (!is_array($formArray))
            exit(0);
        
        $ffh = new FieldFormHelper();
        $ffh->putFields($formArray);
        $html = $ffh->getHTML();
        
        echo $html;
    }
    
    private function __checkPluginControl($request)
    {
        $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
        $controlName = $request["controlname"];
        $plugin = $pm->getPlugin($controlName);
        try
        {
            $res = $plugin->testControl();
            if ($res == false)
                throw new Exception("Control has returned a FALSE value");
            
        } catch (Exception $ex) {
            echo "0";
        }
        
        echo "1";
        exit(0);
        
    }
    
    function sanitizeRequest($array)
    {
        $newArray = array();
        foreach ($array as $key => $value)
        {
            //$sanitized = sql_sanitize($value);
            $newArray[$key] = $value;
        }
        unset($key);
        unset($value);
        
        return $newArray;
    }
}

?>