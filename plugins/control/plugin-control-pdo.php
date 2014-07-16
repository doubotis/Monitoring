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

class PDOControlDescriptor implements AbstractPluginControlDescriptor
{
    // Variables
    var $host = "";
    var $username = "";
    var $password = "";
    var $db = "";
    
    public function __construct()
    {
        
    }
    
    public function pluginName()
    {
        return "Base de données (PHP PDO)";
    }
    
    public function loadConfig($configCode)
    {
        $content = json_decode($configCode, true);
        $this->host = $content["host"];
        $this->username = $content["username"];
        $this->password = $content["password"];
        $this->db = $content["db"];
    }
    
    public function storeConfig()
    {
        $arr = array(   "host" => $this->host,
                        "username" => $this->username,
                        "password" => $this->password,
                        "db" => $this->db
                    );
        return json_encode($arr);
    }
    
    public function loadForm()
    {
        $arr = array();
        array_push($arr, array( "id" => "_host", "type" => "text", "label" => "Hôte/IP", "defaultValue" => $this->host ));
        array_push($arr, array( "id" => "_username", "type" => "text", "label" => "Utilisateur", "defaultValue" => $this->username ));
        array_push($arr, array( "id" => "_password", "type" => "password", "label" => "Mot de passe", "defaultValue" => $this->password ));
        array_push($arr, array( "id" => "_db", "type" => "text", "label" => "DB", "defaultValue" => $this->db ));
        
        return $arr;
    }
    
    public function storeForm($array)
    {
        $this->host = $array["_host"];
        $this->username = $array["_username"];
        $this->password = $array["_password"];
        $this->db = $array["_db"];
    }

    public function testControl()
    {
        return false;
    }

}
