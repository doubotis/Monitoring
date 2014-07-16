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

class FalseControlDescriptor implements AbstractPluginControlDescriptor
{
    public function __construct()
    {
        ;
    }
    
    public function pluginName()
    {
        return "Toujours Faux - Retourne FALSE à tous les tests";
    }
    
    public function loadConfig($configCode)
    {
        ;
    }
    
    public function storeConfig()
    {
        ;
    }
    
    public function loadForm()
    {

    }
    
    public function storeForm($array)
    {
        ;
    }

    public function testControl()
    {
        return false;
    }

}
