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
 */

require_once(dirname(__FILE__) . '/../interface/startOfLine.interface.php');
require_once(dirname(__FILE__) . '/../interface/endOfLine.interface.php');

class emphasize implements startOfLine
{
    const regular_expression = '/(\'{2,5})(.+?)(\'{2,5}|$)/';
    
    public function __construct()
    {
        
    }
    
    public function startOfLine($line) 
    {
        return preg_replace_callback(emphasize::regular_expression,array($this,'replace_callback'),$line);
    } 
    
    private function replace_callback($matches)
    {
        $output = "";
        
        $ammount = min(strlen($matches[1]),strlen($matches[3]));

        if(strlen($matches[3]) == 0)
        {
            $matches[3] = $matches[1];
            $ammount = strlen($matches[3]);
        }
        
        $output = str_pad($output, strlen($matches[1]) - strlen($matches[3]), "'", STR_PAD_LEFT);
        $output .= $matches[2];
        $output = str_pad($output, strlen($output) + (strlen($matches[3]) - strlen($matches[1])), "'", STR_PAD_RIGHT);

        switch($ammount)
        {
            case 2:
                $output = '<em>' . $output . '</em>';
            break;
            case 3:
                $output = '<strong>' . $output . '</strong>';
            break;
            case 4:
            case 5:
                $output = '<em><strong>' . $output . '</strong></em>';
            break;
        }
        
        return $output;
    }
    
}

?>