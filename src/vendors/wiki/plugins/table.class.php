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

class table implements startOfLine
{
    const regular_expression_start = '/^\{\|(.*)/i';
    const regular_expression_end = '/^\|\}(.*)/i';
    const regular_expression_row = '/^\|\-(.*)/i';
    const regular_expression_th = '/^\!(.+?)(\|.*|$)/i';
    const regular_expression_td = '/^\|(.+?)(\|.*|$)/i';
    
    private $open_tables = null;
    
    public function __construct()
    {
        $this->open_tables = array();
    }
    
    public function startOfLine($line)
    {
        //Check if it's an open tag
        if(preg_match(table::regular_expression_start, $line,$matches))
        {
            //Open table
            $line = "<table " . $matches[1] . ">";
            
            $this->open_tables[] = array('tr' => false,'td' =>false,'th' => false);
            
            $line .= "<tr>";
            $this->open_tables[count($this->open_tables) - 1]['tr'] = true;            
        }
        
        if(count($this->open_tables) > 0)
        {
            //End of a table.
            if(preg_match(table::regular_expression_end, $line,$matches))
            {
                //Open table
                if($this->open_tables[count($this->open_tables) - 1]['tr'] === true)
                {
                    $line = "</tr></table>" . substr($line, 2);
                }
                else 
                {
                    $line = "</table>" . substr($line, 2);
                }
                
                array_pop($this->open_tables);
            }
            
            //Check for rows columns or anything else
            if(preg_match(table::regular_expression_row, $line,$matches))
            {
                //Start Row
                if($this->open_tables[count($this->open_tables) - 1]['tr'] === false)
                {
                    $line = "<tr>" . substr($line, 2);
                    $this->open_tables[count($this->open_tables) - 1]['tr'] = true;
                }
                else
                {
                    //if were closing the TR we Need to close any open td or th
                    $line = "</tr><tr>" . substr($line, 2);
                }
            }
            
            if(count($this->open_tables) > 0 && $this->open_tables[count($this->open_tables) - 1]['tr'] === true)
            {
                if(preg_match(table::regular_expression_th, $line,$matches))
                {
                    if($matches[2] === "")
                    {
                        $line = "<th>" . $matches[1] . "</th>";
                    }
                    else
                    {
                        $line = "<th " . $matches[1] . ">" . substr($matches[2],1) . "</th>";
                    }
                }
                
                if(preg_match(table::regular_expression_td, $line,$matches))
                {
                    if($matches[2] === "")
                    {
                        $line = "<td>" . $matches[1] . "</td>";
                    }
                    else
                    {
                        $line = "<td " . $matches[1] . ">" . substr($matches[2],1) . "</td>";
                    }
                }
            }
         }
        
        return $line;
    }
            
}

?>