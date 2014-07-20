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

class SecurityManager
{
    // Constantes
    const SECURITY_MANAGER_MASK_LOGGED = 2000;
    const SECURITY_MANAGER_MASK_BOT = 2001;
    const SECURITY_MANAGER_MASK_ADMIN = 2002;
    
    const SECURITY_MANAGER_VISITOR = 1000;
    const SECURITY_MANAGER_MARKETING = 1001;
    const SECURITY_MANAGER_CONTROLLER = 1002;
    const SECURITY_MANAGER_ADMIN = 1003;
    const SECURITY_MANAGER_SUPERADMIN = 1004;
    
    // Variables
    var $allowed = array();
    var $permissions = array();
    
    function __construct()
    {
        $this->__syncSuperAdminIfNeeded();
    }
    
    function denyAll()
    {
        $allowed = array();
    }
    
    function deny($kind)
    {
        $index = array_search($kind, $allowed);
        if ($index != false)
        {
            $allowed = array_slice($allowed, $index);
        }
    }
    
    function denyPermission($perm)
    {
        
    }
    
    function allowAll()
    {
        $allowed = array(SECURITY_MANAGER_VISITOR);
    }
    
    function allow($kind)
    {
        $masks = array(SecurityManager::SECURITY_MANAGER_MASK_LOGGED, SecurityManager::SECURITY_MANAGER_MASK_BOT, SecurityManager::SECURITY_MANAGER_MASK_ADMIN);
        $kinds = array(SecurityManager::SECURITY_MANAGER_VISITOR, SecurityManager::SECURITY_MANAGER_MARKETING, SecurityManager::SECURITY_MANAGER_CONTROLLER, SecurityManager::SECURITY_MANAGER_ADMIN, SecurityManager::SECURITY_MANAGER_SUPERADMIN);
        
        if (!in_array($kind, $masks) && !in_array($kind, $kinds))
            throw new Exception("Not an authorized value");
        
        array_push($this->allowed, $kind);
    }
    
    function allowPermission($perm)
    {
        
    }
    
    /** Check the security depending on environment variables. */
    function checkSecurityAccess()
    {
        if (!$this->isAuthorized())
            throw new SecurityAccessException("Accès interdit");
    }
    
    function checkSecurity()
    {
        if (!$this->isAuthorized())
            throw new SecurityException("Accès interdit");
    }
    
    function isAuthorized()
    {
        if (in_array(SecurityManager::SECURITY_MANAGER_VISITOR, $this->allowed))
            return true;        // All is authorized
        
        $isSuperAdmin = false;
        $isAdmin = false;
        
        try
        {
            // Get user id
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_AUTH_DBNAME . "";
            $pdo =  new PDO($dsn, DB_AUTH_USERNAME, DB_AUTH_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == -1)
            {
                $isSuperAdmin = true;
                $isAdmin = true;
            }
            
            $sth = $pdo->prepare("SELECT * FROM users WHERE id = ? AND rights LIKE 'admin'");
            $sth->execute(array($_SESSION["user_id"]));
            $res = $sth->fetchAll();
            if (count($res) > 0)
                $isAdmin = true;

            if (in_array(SecurityManager::SECURITY_MANAGER_MASK_ADMIN, $this->allowed) && $isAdmin == true)
                    return true;
            
            if (in_array(SecurityManager::SECURITY_MANAGER_SUPERADMIN, $this->allowed) && $isSuperAdmin == true)
                    return true;

            if (in_array(SecurityManager::SECURITY_MANAGER_MASK_BOT, $this->allowed) && __isCrawler($_SERVER['HTTP_USER_AGENT']))
                return true;

            if (in_array(SecurityManager::SECURITY_MANAGER_MASK_LOGGED, $this->allowed) && isset($_SESSION["connected"]))
                return true;

            return false;
        }
        catch (Exception $e)
        {
            // If the database could not be accessed test if this is the superadmin.
            if ($_SESSION["user_id"] == -1)
                return true;
            else
                return false;
        }
    }
    
    private function __isCrawler($USER_AGENT)
    {
        $crawlers = array(
        'Google' => 'Google',
        'MSN' => 'msnbot',
              'Rambler' => 'Rambler',
              'Yahoo' => 'Yahoo',
              'AbachoBOT' => 'AbachoBOT',
              'accoona' => 'Accoona',
              'AcoiRobot' => 'AcoiRobot',
              'ASPSeek' => 'ASPSeek',
              'CrocCrawler' => 'CrocCrawler',
              'Dumbot' => 'Dumbot',
              'FAST-WebCrawler' => 'FAST-WebCrawler',
              'GeonaBot' => 'GeonaBot',
              'Gigabot' => 'Gigabot',
              'Lycos spider' => 'Lycos',
              'MSRBOT' => 'MSRBOT',
              'Altavista robot' => 'Scooter',
              'AltaVista robot' => 'Altavista',
              'ID-Search Bot' => 'IDBot',
              'eStyle Bot' => 'eStyle',
              'Scrubby robot' => 'Scrubby',
              'Facebook' => 'facebookexternalhit',
          );
        
        // to get crawlers string used in function uncomment it
        // it is better to save it in string than use implode every time
        // global $crawlers
         $crawlers_agents = implode('|',$crawlers);
        if (strpos($crawlers_agents, $USER_AGENT) === false)
            return false;
        else
        {
            return true;
        }
    }
    
    private function __syncSuperAdminIfNeeded()
    {
        if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != -1)
            return;
        
        try
        {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_AUTH_DBNAME . "";
            $pdo =  new PDO($dsn, DB_AUTH_USERNAME, DB_AUTH_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sth = $pdo->prepare("UPDATE users SET username = ?, password = ?, email = ?, email_active = ?, phone = ?, phone_active = ? WHERE id = -1");
            $res = $sth->execute(array(AC_SUPERADMIN_USERNAME, AC_SUPERADMIN_PASSWORD, 
                AC_SUPERADMIN_EMAIL, AC_SUPERADMIN_EMAIL_ACTIVE, 
                AC_SUPERADMIN_PHONE, AC_SUPERADMIN_PHONE_ACTIVE));
            if ($res == 0)
                throw new Exception("Unable to sync the SuperAdmin user with the database.");
            
        }
        catch (Exception $e)
        {
            Log::getLogger()->write(Log::LOG_ERROR, "Unable to sync the SuperAdmin user with the database.", $e);
        }
    }
}

?>