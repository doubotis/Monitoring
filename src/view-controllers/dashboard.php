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

class DashboardController {
    
    var $pdo = null;
    var $sm = null;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sm = new SecurityManager();
        $this->sm->denyAll();
        $this->sm->allow(SECURITY_MANAGER_MASK_LOGGED);
        $this->sm->checkSecurityAccess();
    }
    
    function buildTemplate($tpl)
    {
        $category = isset($_REQUEST["cat"]) ? $_REQUEST["cat"] : "overview";
        $tpl->assign('category', $category);
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
        
        switch ($category)
        {
            
            case 'overview':
                $this->assignCategoryOverview($tpl);
                $tpl->display('controller_dashboard.tpl');
                break;
            case 'alerts':
                $this->assignCategoryAlerts($tpl);
                $tpl->display('controller_dashboard.tpl');
                break;
            case 'controllers':
                $this->assignCategoryControllers($tpl);
                $tpl->display('controller_dashboard.tpl');
                break;
            case 'alarms':
                $this->assignCategoryAlarms($tpl);
                $tpl->display('controller_dashboard.tpl');
                break;
            case 'logs':
                $this->assignCategoryLogs($tpl);
                $tpl->display('controller_dashboard.tpl');
                break;
            default:
                $tpl->assign('view', 'view_dashboard_' . $category);
                $tpl->display('controller_dashboard.tpl');
                break;
        }
        
    }
    
    function assignCategoryOverview($tpl)
    {
        $sth = $this->pdo->prepare("SELECT alerts.id, alarms.type, controllers.name, timestamp, username FROM alerts INNER JOIN alarms ON (alarms.id = alerts.alarm_id) INNER JOIN controllers ON (controllers.id = alerts.controller_id) LEFT JOIN users ON (users.id = alerts.user_id) WHERE resolved = 0 ORDER BY timestamp");
        $sth->execute();
        $res = $sth->fetchAll();
        
        $tpl->assign('alerts_data', $res);
        $tpl->assign('view', 'view_dashboard_overview');
    }
    
    function assignCategoryAlerts($tpl)
    {
        $action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "list";
        
        if ($action == "list")
        {
            $sth = $this->pdo->prepare("SELECT alerts.id, alarms.type, controllers.name, controllers.descr AS controller_descr, timestamp, username FROM alerts INNER JOIN alarms ON (alarms.id = alerts.alarm_id) INNER JOIN controllers ON (controllers.id = alerts.controller_id) LEFT JOIN users ON (users.id = alerts.user_id) WHERE resolved = 0 ORDER BY timestamp");
            $sth->execute();
            $res = $sth->fetchAll();
            $current_alerts = $res;
            
            $sth = $this->pdo->prepare("SELECT alerts.id, alarms.type, controllers.name, controllers.descr AS controller_descr, timestamp, username FROM alerts INNER JOIN alarms ON (alarms.id = alerts.alarm_id) INNER JOIN controllers ON (controllers.id = alerts.controller_id) LEFT JOIN users ON (users.id = alerts.user_id) WHERE resolved = 1 ORDER BY timestamp");
            $sth->execute();
            $res = $sth->fetchAll();
            $old_alerts = $res;

            $tpl->assign('alerts_data', $current_alerts);
            $tpl->assign('old_alerts_data', $old_alerts);
            $tpl->assign('view', 'view_dashboard_alerts');
        }
        else if ($action == "info")
        {
            $sth = $this->pdo->prepare("SELECT alerts.id, controllers.id AS controller_id, alarms.type, controllers.name, controllers.descr AS controller_descr, exception, timestamp, last_interv, username, resolved FROM alerts INNER JOIN alarms ON (alarms.id = alerts.alarm_id) INNER JOIN controllers ON (controllers.id = alerts.controller_id) LEFT JOIN users ON (users.id = alerts.user_id) WHERE alerts.id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            $item = $res;
            
            
            $sth = $this->pdo->prepare("SELECT start_timestamp, end_timestamp, users.id, username FROM interventions INNER JOIN alerts ON (alerts.id = interventions.alert_id) INNER JOIN users ON (users.id = interventions.user_id) WHERE alert_id = ? ORDER BY start_timestamp");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetchAll();
            
            $historic = new Historic($item, $res);
            
            $tpl->assign('item', $item);
            $tpl->assign('historic_data', $historic->getRepresentativeArray());
            $tpl->assign('historic_timeline', $historic->getTimelineArray());
            $tpl->assign('view', 'view_dashboard_alerts_detail');
        }
    }
    
    function assignCategoryControllers($tpl)
    {
        $action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "list";
        if ($action == "list")
        {
            $sth = $this->pdo->prepare("SELECT id, name, alarm_count, enabled FROM controllers");
            $sth->execute();
            $res = $sth->fetchAll();

            $tpl->assign('controllers_data', $res);
            $tpl->assign('view', 'view_dashboard_controllers');
        }
        else if ($action == "add")
        {
            $item = array("id" => -1, "name" => "", "descr" => "", "enabled" => 1, "strict" => 0, "control_type" => "", "control_code" => "", "alarm_id" => 1);
            
            // Request for alarms
            $sth = $this->pdo->prepare("SELECT id, name FROM alarms");
            $sth->execute();
            $alarms = $sth->fetchAll();
            
            // Request for controls
            $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
            $plugins = $pm->getPlugins();
            
            // Request current control
            $key = array_keys($plugins);
            $key = $key[0];
            $plugin = $plugins[$key];
            $ffh = new FieldFormHelper();
            $ffh->putFields($plugin->loadForm());
            $subformHtml = $ffh->getHTML();
            
            $tpl->assign('action', $action);
            $tpl->assign('item', $item);
            $tpl->assign('alarms_data', $alarms);
            $tpl->assign('controls_data', $plugins);
            $tpl->assign('subform_html', $subformHtml);
            $tpl->assign('view', 'view_dashboard_controllers_form');
        }
        else if ($action == "edit")
        {
            $sth = $this->pdo->prepare("SELECT id, name, descr, enabled, strict, control_type, control_code, alarm_id FROM controllers WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            $item = $res;
            
            // Request for alarms
            $sth = $this->pdo->prepare("SELECT id, name FROM alarms");
             $sth->execute();
            $alarms = $sth->fetchAll();
            
             // Request for controls
            $pm = new PluginManager(PluginManager::PLUGIN_TYPE_CONTROL);
            $plugins = $pm->getPlugins();
            
            // Request current control
            $plugin = $pm->getPlugin($item["control_type"]);
            $plugin->loadConfig($item["control_code"]);
            $ffh = new FieldFormHelper();
            $ffh->putFields($plugin->loadForm());
            $subformHtml = $ffh->getHTML();
            
            $tpl->assign('action', $action);
            $tpl->assign('item', $item);
            $tpl->assign('alarms_data', $alarms);
            $tpl->assign('controls_data', $plugins);
            $tpl->assign('subform_html', $subformHtml);
            $tpl->assign('view', 'view_dashboard_controllers_form');
        }
    }
    
    function assignCategoryAlarms($tpl)
    {
        $action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "list";
        if ($action == "list")
        {
            $sth = $this->pdo->prepare("SELECT id, name, type, email, sms FROM alarms");
            $sth->execute();
            $res = $sth->fetchAll();

            $tpl->assign('alarms_data', $res);
            $tpl->assign('view', 'view_dashboard_alarms');
        }
        else if ($action == "add")
        {
            $item = array("id" => -1, "name" => "", "type" => 1, "email" => 0, "sms" => 0);
            $tpl->assign('action', $action);
            $tpl->assign('item', $item);
            $tpl->assign('view', 'view_dashboard_alarms_form');
        }
        else if ($action == "edit")
        {
            $sth = $this->pdo->prepare("SELECT id, name, type, email, sms FROM alarms WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            $item = $res;
            
            $tpl->assign('action', $action);
            $tpl->assign('item', $item);
            $tpl->assign('view', 'view_dashboard_alarms_form');
        }
    }
    
    function assignCategoryLogs($tpl)
    {
        $logs = Log::getLogger()->tail(100);
        
        $logs = preg_replace("/[\r\n]/", "<br/>", $logs);
        $logs = str_replace('\t', "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $logs);
        
        $tpl->assign('logs', $logs);
        $tpl->assign('view', 'view_dashboard_logs');
    }
}

?>