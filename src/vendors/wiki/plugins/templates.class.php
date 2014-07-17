<?php

/*
 * @package     PHP5 Wiki Parser
 * @author      Dan Goldsmith
 * @copyright   Dan Goldsmith 2012
 * @link        http://d2g.org.uk/
 * @version     {SUBVERSION_BUILD_NUMBER}
 * 
 * @licence     MPL 2.0
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 * Media Wiki Template Support
 * As Outlined in http://www.mediawiki.org/wiki/Help:Templates
 * As requested By Betty Chang on 2012-05-25
 */

require_once(dirname(__FILE__) . '/../interface/startOfFile.interface.php');
/*
 * Mini Wiki Templates outlined in {{}} Tags
 */
class templates implements startOfFile
{
    const regular_expression = '{{(.*?)}}';
    
    public function __construct() 
    {
        
    }
    
    public function startOfFile($file_content) 
    {
        return preg_replace_callback(self::regular_expression,array($this,'useTemplate'),$file_content);        
    }
    
    private function useTemplate($matches)
    {
        //So we found a template lets get the template name and any variables
        $parameters = array();
        $template_detail = substr($matches[1], 1,strlen($matches[1]) - 2);
        
        $parts = preg_split("/[^\[]*\|/", $template_detail);
        
        $template_name = array_shift($parts);
        $i = 0;
        
        foreach($parts as $part)
        {
            if(strpos($part, "=") !== false)
            {
                $subparts = explode("=",$part);
                $parameters[$subparts[0]] = $subparts[1];
            }
            else
            {
               $parameters[$i] = $part; 
               $i++;
            }
        }
        
        //var_dump($parameters);
        return;
    }
}

?>