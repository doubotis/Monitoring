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

require_once dirname(__FILE__) . '/../utils/utils-logging.php';
require_once dirname(__FILE__) . '/jtraceex.php';

class Log
{
    // Constantes
    const LOG_FATAL = 0;
    const LOG_ERROR = 1;
    const LOG_WARNING = 2;
    const LOG_ALERT = 3;
    const LOG_INFO = 4;
    const LOG_DEBUG = 5;
    const LOG_VERBOSE = 6;
    
    // Variables
    private static $__logInstance = null;
    
    private $directoryLog = null;
    
    public static function getLogger()
    {
        if (!isset($__logInstance))
            $__logInstance = new Log();
        return $__logInstance;
    }
    
    protected function __construct()
    {
        $this->directoryLog = WEBAPP_DIR . '../.log/';
    }
    
    public function getLogDirectory()
    {
        return $this->directoryLog;
    }
    
    /** Get the last count of lines specified in parameter and return it into an array of strings. */
    public function tailAsArray($lines)
    {
        
    }
    
    /** Get the last count of lines specified in parameter and return it into a large string. */
    public function tail($lines)
    {
        return __file_backread($this->directoryLog . 'log.txt', $lines);
    }
    
    /** Write a message in the Log. If specified, $exception will display the complete stack trace. */
    public function write($kind, $text, $exception = null)
    {   
        $string = "[" . date("m/d/y H:i:s") . "]";
        $string .= "[" . $kind . "] ";
        $string .= $text;
        $string .= "\n";
        
        if (isset($exception) && $exception instanceof Exception)
        {
            
            $string .= __jTraceEx($exception);
            $string .= "\n";
        }
        
        
        __append_line_to_limited_text_file($string, $this->directoryLog . 'log.txt');

        
    }
}