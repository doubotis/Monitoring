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

class TrueControlDescriptor implements AbstractPluginControlDescriptor
{
    public function __construct()
    {
        
    }
    
    public function pluginName()
    {
        return "Toujours Vrai - Retourne TRUE à tous les tests";
    }
    
    public function loadConfig($configCode)
    {
        
    }
    
    public function storeConfig()
    {
        return "";
    }
    
    public function loadForm()
    {
        return null;
    }
    
    public function storeForm($array)
    {
        
    }    

    public function testControl()
    {
        return true;
    }

}
