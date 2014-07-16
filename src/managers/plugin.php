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

class PluginManager
{
    // Constants
    const PLUGIN_TYPE_CONTROL = "control";
    
    // Variables
    var $type = null;
    var $plugins = array();
    
    public function __construct($type)
    {
        $this->type = $type;
        $this->__build();
    }
    
    private function __build()
    {
        if ($handle = opendir(PLUGIN_DIR . $this->type . '/'))
        {
            while (false !== ($entry = readdir($handle)))
            {
                if ($entry != "." && $entry != ".." && endsWith($entry, '.php'))
                {
                    try
                    {
                        $this->__preparePlugin(PLUGIN_DIR . $this->type . '/' . $entry);
                    }
                    catch (Exception $e) { echo $e->getMessage(); continue; }
                }
            }
            closedir($handle);
        }
    }
    
    private function __preparePlugin($file)
    {
        $classNames = $this->__prepareClasses($file);
        $this->__prepareImports($file);
        $this->__prepareInstances($classNames);
    }
    
    private function __prepareClasses($file)
    {
        $classNames = $this->__getClasses($file);
        if (count($classNames) == 0)
            throw new Exception("No classes defined");
        return $classNames;
    }
    
    private function __prepareImports($file)
    {
        include_once($file);
    }
    
    private function __prepareInstances($classNames)
    {
        for ($i=0; $i < count($classNames); $i++)
        {
            $classInstance = new $classNames[$i];
            $implements = class_implements($classInstance);
            if (!in_array('AbstractPluginControlDescriptor', $implements))
            {
                    continue;
            }
            
            $this->plugins[$classNames[$i]] = $classInstance;
        }
        
        asort($this->plugins);
    }
    
    private function __getClasses($file)
    {
        $classes = array();
        $php_file = file_get_contents($file);
        $tokens = token_get_all($php_file);
        $class_token = false;
        foreach ($tokens as $token)
        {
            if (is_array($token))
            {
                if ($token[0] == T_CLASS)
                {
                    $class_token = true;

                } else if ($class_token && $token[0] == T_STRING)
                {
                    array_push($classes, $token[1]);
                    $class_token = false;
                }
            }     
        }
        
        return $classes;
    }
    
    public function getPluginsNames()
    {
        return array_keys($this->plugins);
    }
    
    public function getPlugins()
    {
        return $this->plugins;
    }
    
    public function getPluginsDescriptor()
    {
        
    }
    
    public function getPlugin($name)
    {
        return $this->plugins[$name];
    }
    
    
}
