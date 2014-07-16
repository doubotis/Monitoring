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

class HTTPStatusCodeControlDescriptor implements AbstractPluginControlDescriptor
{
    // Variables
    var $url = "";
    var $timeout = "";
    var $statusCode = "";
    
    public function __construct()
    {
        
    }
    
    public function pluginName()
    {
        return "HTTP - Status Code";
    }
    
    public function loadConfig($configCode)
    {
        $content = json_decode($configCode, true);
        $this->url = $content["url"];
        $this->timeout = $content["timeout"];
        $this->statusCode = $content["status_code"];
    }
    
    public function storeConfig()
    {
        $arr = array(   "url" => $this->url,
                        "timeout" => $this->timeout,
                        "status_code" => $this->statusCode
                    );
        return json_encode($arr);
    }
    
    public function loadForm()
    {
        $arr = array();
        array_push($arr, array( "id" => "_url", "type" => "text", "label" => "URL", "defaultValue" => $this->url ));
        array_push($arr, array( "id" => "_timeout", "type" => "numeric", "label" => "Timeout (milisecondes)", "defaultValue" => $this->timeout ));
        array_push($arr, array( "id" => "_sc", "type" => "numeric", "label" => "Status Code", "defaultValue" => $this->statusCode ));
        
        return $arr;
    }
    
    public function storeForm($array)
    {
        $this->url = $array["_url"];
        $this->timeout = $array["_timeout"];
        $this->statusCode = $array["_sc"];
    }

    public function testControl()
    {
        return false;
    }

}
