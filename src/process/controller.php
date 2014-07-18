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

class ControllerProcess
{
    var $pdo;
    var $sm;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sm = new SecurityManager();
        $this->sm->denyAll();
        $this->sm->allow(SECURITY_MANAGER_MASK_LOGGED);
        $this->sm->checkSecurity();
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
    }
    
    function add($name, $descr, $state, $strict, $type, $alarm_id, $others)
    {
        if (!isset($state)) $state = 0;
        if (!isset($strict)) $strict = 0;
        
        $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
        $plugin = $pm->getPlugin($type);
        $plugin->storeForm($others);
        $code = $plugin->storeConfig();
        
        $sth = $this->pdo->prepare("INSERT INTO controllers (id, name, descr, alarm_count, enabled, strict, control_type, control_code, alarm_id) VALUES (0, ?, ?, ?, ?, ?, ?, ?, ?)");
        $res = $sth->execute(array($name, $descr, 0, $state, $strict, $type, $code, $alarm_id));
        if ($res == 0)
        {
            $errorInfo = $sth->errorInfo();
            throw new Exception("Impossible d'ajouter un contrôleur: " . print_r($errorInfo, true));
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Ajout terminé", "descr" => "Le contrôleur a bien été ajouté");
        header('Location: ' . '/monitoring/?v=dashboard&cat=controllers');
    }
    
    function edit($id, $name, $descr, $state, $strict, $type, $alarm_id, $others)
    {
        if (!isset($state)) $state = 0;
        if (!isset($strict)) $strict = 0;
        
        $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
        $plugin = $pm->getPlugin($type);
        $plugin->storeForm($others);
        $code = $plugin->storeConfig();
        
        $sth = $this->pdo->prepare("UPDATE controllers SET name = ?, descr = ?, enabled = ?, strict = ?, control_type = ?, control_code = ?, alarm_id = ? WHERE id = ?");
        $res = $sth->execute(array($name, $descr, $state, $strict, $type, $code, $alarm_id, $id));
        if ($res == 0)
        {
            $errorInfo = $sth->errorInfo();
            throw new Exception("Impossible de modifier ce contrôleur: " . print_r($errorInfo, true));
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "Le contrôleur a bien été modifié");
        header('Location: ' . '/monitoring/?v=dashboard&cat=controllers');
    }
}
