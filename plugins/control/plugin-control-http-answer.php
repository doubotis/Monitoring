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

class HTTPAnswerControlDescriptor implements AbstractPluginControlDescriptor
{
    // Constants
    const HTTP_ANSWER_CHECK_TYPE_CONTAINS = 0;
    const HTTP_ANSWER_CHECK_TYPE_NOT_CONTAINS = 1;
    const HTTP_ANSWER_CHECK_TYPE_STARTS_WITH = 2;
    const HTTP_ANSWER_CHECK_TYPE_ENDS_WITH = 3;
    
    // Variables
    var $url = "";
    var $timeout = "";
    var $checkType = HTTPAnswerControlDescriptor::HTTP_ANSWER_CHECK_TYPE_CONTAINS;
    var $checkValue = "";
    
    
    public function __construct()
    {
        
    }
    
    public function pluginName()
    {
        return "HTTP - Contenu Réponse";
    }
    
    public function loadConfig($configCode)
    {
        $content = json_decode($configCode, true);
        $this->url = $content["url"];
        $this->timeout = $content["timeout"];
        $this->checkType = $content["checkType"];
        $this->checkValue = $content["checkValue"];
    }
    
    public function storeConfig()
    {
        $arr = array(   "url" => $this->url,
                        "timeout" => $this->timeout,
                        "checkType" => $this->checkType,
                        "checkValue" => $this->checkValue,
                    );
        return json_encode($arr);
    }
    
    public function loadForm()
    {
        $values = array(   array("label" => "Contient", "value" => HTTPAnswerControlDescriptor::HTTP_ANSWER_CHECK_TYPE_CONTAINS),
                            array("label" => "Ne Contient pas", "value" => HTTPAnswerControlDescriptor::HTTP_ANSWER_CHECK_TYPE_NOT_CONTAINS),
                            array("label" => "Commence avec", "value" => HTTPAnswerControlDescriptor::HTTP_ANSWER_CHECK_TYPE_STARTS_WITH),
                            array("label" => "Finit avec", "value" => HTTPAnswerControlDescriptor::HTTP_ANSWER_CHECK_TYPE_ENDS_WITH)
                        );
        
        $arr = array();
        array_push($arr, array( "id" => "_url", "type" => "text", "label" => "URL", "defaultValue" => $this->url ));
        array_push($arr, array( "id" => "_timeout", "type" => "numeric", "label" => "Timeout (milisecondes)", "defaultValue" => $this->timeout ));
        array_push($arr, array( "id" => "_check_type", "type" => "select", "label" => "Type de vérification", "defaultValue" => $this->checkType, 
            "values" => $values));
        array_push($arr, array( "id" => "_check_value", "type" => "textarea", "label" => "Valeur", "defaultValue" => $this->checkValue ));
        
        return $arr;
    }
    
    public function storeForm($array)
    {
        $this->url = $array["_url"];
        $this->timeout = $array["_timeout"];
        $this->checkType = $array["_check_type"];
        $this->checkValue = $array["_check_value"];
    }

    public function testControl()
    {
        return false;
    }

}
