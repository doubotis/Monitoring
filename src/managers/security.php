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

define('SECURITY_MANAGER_MASK_LOGGED', 2000);
define('SECURITY_MANAGER_MASK_BOT', 2001);
define('SECURITY_MANAGER_MASK_ADMIN', 2002);

define('SECURITY_MANAGER_VISITOR', 1000);
define('SECURITY_MANAGER_MARKETING', 1001);
define('SECURITY_MANAGER_CONTROLLER', 1002);
define('SECURITY_MANAGER_ADMIN', 1003);
define('SECURITY_MANAGER_SUPERADMIN', 1004);

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
        $masks = array(SECURITY_MANAGER_MASK_LOGGED, SECURITY_MANAGER_MASK_BOT, SECURITY_MANAGER_MASK_ADMIN);
        $kinds = array(SECURITY_MANAGER_VISITOR, SECURITY_MANAGER_MARKETING, SECURITY_MANAGER_CONTROLLER, SECURITY_MANAGER_ADMIN, SECURITY_MANAGER_SUPERADMIN);
        
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
            throw new SecurityAccessException("Forbiden Access");
    }
    
    function checkSecurity()
    {
        if (!$this->isAuthorized())
            throw new SecurityException("Forbiden Access");
    }
    
    function isAuthorized()
    {
        if (in_array(SECURITY_MANAGER_VISITOR, $this->allowed))
            return true;        // All is authorized
        
        if (in_array(SECURITY_MANAGER_MASK_BOT, $this->allowed) && isCrawler($_SERVER['HTTP_USER_AGENT']))
            return true;
        
        if (in_array(SECURITY_MANAGER_MASK_LOGGED, $this->allowed) && isset($_SESSION["connected"]))
            return true;
        
        return false;
    }
    
    function isCrawler($USER_AGENT)
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
}

?>