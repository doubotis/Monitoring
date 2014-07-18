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

class AdminProcess
{
    var $pdo;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $sm = new SecurityManager();
        $sm->denyAll();
        $sm->allow(SecurityManager::SECURITY_MANAGER_MASK_ADMIN);
        $sm->checkSecurity();
    }
    
    function setup($dbHost, $dbUsername, $dbPassword, $dbName, $controlThreads, $controlInterval)
    {
        if ($dbHost == "" || $dbUsername == "" || $dbPassword == "" || $dbName == "")
            throw new Exception("La configuration de Base de données est incomplète");
        
        /*if ($controlThreads == "" || $controlInterval == "" || !is_numeric($controlThreads) || !is_numeric($controlInterval))
            throw new Exception("La configuration de Contrôle est incomplète");*/
        
        if ($controlThreads == "" || !is_numeric($controlThreads))
            throw new Exception("Le champ Threads de contrôle est vide");
        
        if ($controlInterval == "" || !is_numeric($controlInterval))
            throw new Exception("Le champ Intervalle de contrôle est vide");
        
        $cm = new ConfigManager(ADMIN_CONFIG_PATH);
        $cm->loadINIFile();
        
        $cm->setConfig('database', 'db_host', $dbHost);
        $cm->setConfig('database', 'db_auth_username', $dbUsername);
        $cm->setConfig('database', 'db_auth_password', $dbPassword);
        $cm->setConfig('database', 'db_auth_dbname', $dbName);
        
        $cm->setConfig('control', 'ac_control_threads', $controlThreads);
        $cm->setConfig('control', 'ac_control_frequency', $controlInterval);
        
        $cm->saveINIFile();
        
        $_SESSION["message"] = array("type" => "success", "title" => "Configuration terminée", "descr" => "La configuration a été modifiée avec succès.");
        header('Location: ' . '/monitoring/?v=admin&tab=config');
        exir(0);
    }
    
}
