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

class Permission
{
    // Constants
    const PERMISSION_ACCESS_ADMIN = "perm.access.admin";
    
    const PERMISSION_ACCESS_DASHBOARD_OVERVIEW = "perm.access.dashboard.overview";
    const PERMISSION_ACCESS_DASHBOARD_ALERTS = "perm.access.dashboard.alerts";
    const PERMISSION_ACCESS_DASHBOARD_LOGS = "perm.access.dashboard.logs";
    const PERMISSION_ACCESS_DASHBOARD_ANALYTICS = "perm.access.dashboard.analytics";
    const PERMISSION_ACCESS_DASHBOARD_PROXMOX = "perm.access.dashboard.proxmox";
    const PERMISSION_ACCESS_DASHBOARD_CONTROLLERS = "perm.access.dashboard.controllers";
    const PERMISSION_ACCESS_DASHBOARD_SHORTCUTS = "perm.access.dashboard.shortcuts";
    const PERMISSION_ACCESS_DASHBOARD_ALARMS = "perm.access.dashboard.alarms";
    const PERMISSION_ACCESS_DASHBOARD_USERS = "perm.access.dashboard.users";
    const PERMISSION_ACCESS_DASHBOARD_ADVANCED = "perm.access.dashboard.advanced";
    
    const PERMISSION_CONTROLLERS_ADD = "perm.controllers.create";
    const PERMISSION_CONTROLLERS_EDIT = "perm.controllers.edit";
    const PERMISSION_CONTROLLERS_DELETE = "perm.controllers.delete";
    const PERMISSION_ALERTS_MANAGE = "perm.alerts.manage";
    const PERMISSION_SHORTCUTS_CREATE = "perm.shortcuts.create";
    const PERMISSION_SHORTCUTS_EDIT = "perm.shortcuts.edit";
    const PERMISSION_SHORTCUTS_DELETE = "perm.shortcuts.delete";
    const PERMISSION_ALARMS_CREATE = "perm.alarms.create";
    const PERMISSION_ALARMS_EDIT = "perm.alarms.edit";
    const PERMISSION_ALARMS_DELETE = "perm.alarms.delete";
    const PERMISSION_ADVANCED_MANAGE = "perm.advanced.manage";
    
    // Variables
    var $descrs = array();
    
    function __construct()
    {
        // Build descriptions
        $this->descrs[Permission::PERMISSION_ACCESS_ADMIN] = "Donne accès au panneau d'Administrateur. Déverouille automatiquement toutes les autres permissions pour tous les projets.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_OVERVIEW] = "Donne accès à l'Aperçu du Dashboard. Permet de visualiser les alertes en cours et les statistiques global d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_ALERTS] = "Donne accès à la liste des alertes. Permet de visualiser les alertes en cours et l'historique des alertes d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_LOGS] = "Donne accès au log d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_ANALYTICS] = "Donne accès aux statistiques Analytics d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_PROXMOX] = "Donne accès aux conteneurs Proxmox d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_CONTROLLERS] = "Donne accès à la liste des contrôleurs d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_SHORTCUTS] = "Donne accès à la liste des raccourcis d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_ALARMS] = "Donne accès à la liste des alarmes d'un projet.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_USERS] = "Donne accès à la liste des utilisateurs d'un projet. Les utilisateurs n'étant pas affectés au projet donné ne sont pas listés.";
        $this->descrs[Permission::PERMISSION_ACCESS_DASHBOARD_ADVANCED] = "Donne accès aux réglages avancés d'un projet.";
        
        $this->descrs[Permission::PERMISSION_CONTROLLERS_ADD] = "Permet d'ajouter de nouveaux contrôleurs pour un projet.";
        $this->descrs[Permission::PERMISSION_CONTROLLERS_EDIT] = "Permet de modifier les contrôleurs d'un projet.";
        $this->descrs[Permission::PERMISSION_CONTROLLERS_DELETE] = "Permet de supprimer des contrôleurs d'un projet.";
        $this->descrs[Permission::PERMISSION_ALERTS_MANAGE] = "Permet de gérer les alertes d'un projet";
        $this->descrs[Permission::PERMISSION_SHORTCUTS_CREATE] = "Permet d'ajouter de nouveaux raccourcis d'un projet.";
        $this->descrs[Permission::PERMISSION_SHORTCUTS_EDIT] = "Permet de modifier les raccourcis d'un projet.";
        $this->descrs[Permission::PERMISSION_SHORTCUTS_DELETE] = "Permet de supprimer des raccourcis d'un projet.";
        $this->descrs[Permission::PERMISSION_ALARMS_CREATE] = "Permet d'ajouter de nouvelles alarmes pour un projet.";
        $this->descrs[Permission::PERMISSION_ALARMS_EDIT] = "Permet de modifier les alarmes d'un projet.";
        $this->descrs[Permission::PERMISSION_ALARMS_DELETE] = "Permet de supprimer des alarmes d'un projet.";
        $this->descrs[Permission::PERMISSION_ADVANCED_MANAGE] = "Permet de modifier les propriétés avancées d'un projet.";
    }
    
    function getPermissionsArray()
    {
        $perms = array();
        $reflector = new ReflectionClass('Permission');
        $arr = $reflector->getConstants();
        $keys = array_keys($arr);
        
        for ($i=0; $i < count($keys); $i++)
        {
            $key = $keys[$i];
            $value = $arr[$keys[$i]];
            array_push($perms, array("name" => $value, "descr" => $this->descrs[$value]));
        }
        
        return $perms;
    }
}