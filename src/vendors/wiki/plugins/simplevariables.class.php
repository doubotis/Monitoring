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

class simplevariables implements startOfLine
{
    const regular_expression = '/(\{\{([^\}]*?)\}\})/i';
    private $variables = null;
    
    public function __construct()
    {
        $config = wikiParser::getConfigINI();

        if(array_key_exists('SIMPLE_VARIABLES', $config))
        {
            foreach($config['SIMPLE_VARIABLES'] as $variable_name => $php_code)
            {
                $this->variables[$variable_name] = $php_code;
            }
        }
    }
    
    public function startOfLine($line) 
    {
        //So although were passed a line of text we might not actually need to do anything with it.
        return preg_replace_callback(simplevariables::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        if(array_key_exists($matches[2], $this->variables))
        {
            return eval($this->variables[$matches[2]]);
        }
        else
        {
            return $matches[0];
        }
    }
    
}

?>