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

class FieldFormHelper
{
    // Constantes
    const FIELD_TEXTAREA = "textarea";
    const FIELD_TEXT = "text";
    const FIELD_PASSWORD = "password";
    const FIELD_NUMERIC = "numeric";
    const FIELD_SELECT = "select";
    
    // Variables
    var $html = "";
    
    public function __construct()
    {
        
    }
    
    public function putFields($array)
    {
        for ($i = 0; $i < count($array); $i++)
        {
            $el = $array[$i];
            $type = $el["type"];
            if ($type == FieldFormHelper::FIELD_TEXTAREA)
                $this->html .= $this->__textAreaForm($el["id"], $el["label"], $el["defaultValue"]);
            else if ($type == FieldFormHelper::FIELD_TEXT)
                $this->html .= $this->__textForm($el["id"], $el["label"], $el["defaultValue"]);
            else if ($type == FieldFormHelper::FIELD_PASSWORD)
                $this->html .= $this->__passwordForm($el["id"], $el["label"], $el["defaultValue"]);
            else if ($type == FieldFormHelper::FIELD_NUMERIC)
                $this->html .= $this->__numericForm($el["id"], $el["label"], $el["defaultValue"]);
            else if ($type == FieldFormHelper::FIELD_SELECT)
                $this->html .= $this->__selectForm($el["id"], $el["label"], $el["defaultValue"], $el["values"]);
        }
    }
    
    public function getHTML()
    {
        return $this->html;
    }
    
    // ---------------
    
    protected function __textAreaForm($fieldID, $fieldLabel, $defaultValue)
    {
        $html = '<!-- Textarea -->
        <div class="form-group">
        <label class="col-md-4 control-label" for="' . $fieldID . '">' . $fieldLabel . ' :</label>
        <div class="col-md-6">                     
            <textarea class="form-control" id="' . $fieldID . '" name="_' . $fieldID . '" style="width: 100%; height: 230px; 
                font-family: monospace;">' . htmlspecialchars($defaultValue, ENT_QUOTES, 'utf-8') . '</textarea>
        </div>
    </div>';
        
        return $html;
    }
    
    protected function __textForm($fieldID, $fieldLabel, $defaultValue)
    {
        $html = '<!-- Text input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="' . $fieldID . '">' . $fieldLabel . ' :</label>  
            <div class="col-md-6">
            <input id="name" name="' . $fieldID . '" type="text" placeholder="" class="form-control input-md" value="' .  htmlspecialchars($defaultValue, ENT_QUOTES, 'utf-8') . '">
        </div>
        </div>';
        
        return $html;
    }
    
    protected function __passwordForm($fieldID, $fieldLabel, $defaultValue)
    {
        $html = '<!-- Password input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="' . $fieldID . '">' . $fieldLabel . ' :</label>  
            <div class="col-md-6">
            <input id="name" name="' . $fieldID . '" type="password" placeholder="" class="form-control input-md" value="' . htmlspecialchars($defaultValue, ENT_QUOTES, 'utf-8') . '">
        </div>
        </div>';
        
        return $html;
    }
    
    protected function __numericForm($fieldID, $fieldLabel, $defaultValue)
    {
        $html = '<!-- Password input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="' . $fieldID . '">' . $fieldLabel . ' :</label>  
            <div class="col-md-4">
            <input id="name" name="' . $fieldID . '" type="number" placeholder="" class="form-control input-md" value="' . htmlspecialchars($defaultValue, ENT_QUOTES, 'utf-8') . '">
        </div>
        </div>';
        
        return $html;
    }
    
    protected function __selectForm($fieldID, $fieldLabel, $defaultValue, $values)
    {
        $html = '<!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="' . $fieldID . '">' . $fieldLabel .' :</label>
                        <div class="col-md-6">
                            <select id="' . $fieldID . '" name="' . $fieldID . '" class="form-control">';
        for ($i = 0; $i < count($values); $i++)
        {
            if ($defaultValue == $values[$i]["value"])
                $html .= '<option value="' . $values[$i]["value"] . '"  selected>' . $values[$i]["label"] . '</option>';
            else
                $html .= '<option value="' . $values[$i]["value"] . '" >' . $values[$i]["label"] . '</option>';
        }
        
        $html .= '</select>
            </div>
            </div>';
        
        return $html;
    }
}

