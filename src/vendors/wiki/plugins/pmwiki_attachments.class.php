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

class pmwiki_attachments implements startOfLine
{
    const regular_expression = '/Attach:(.*?)(\..*?|)( |$|<)/i';
    
    public function __construct()
    {
        
    }
    
    public function startOfLine($line) 
    {
        //So although were passed a line of text we might not actually need to do anything with it.
        return preg_replace_callback(pmwiki_attachments::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        $isImage = false;
        $image_extensions = array(".jpg",".png",".gif");
        
        if(array_key_exists(2, $matches) && in_array(trim($matches[2]), $image_extensions))
        {
            $isImage = true;
        }
        
        if($isImage)
        {
            //Images
            return "<img src=\"" . $matches[1] . $matches[2] . "\" alt=\"" . $matches[1] . $matches[2] . "\"/>" . $matches[3];
        }
        else
        {
            return "<a href=\"" . $matches[1] . $matches[2] . "\">" . $matches[1] . $matches[2] . "</a>" . $matches[3];
        }
    }
    
}

?>