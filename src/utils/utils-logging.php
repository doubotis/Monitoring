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

// Appends lines to file and makes sure the file doesn't grow too much
function __append_line_to_limited_text_file($text, $filename) {
	if (!file_exists($filename)) { touch($filename); chmod($filename, 0666); }
	if (filesize($filename) > 2*1024*1024) {
		$filename2 = "$filename.old";
		if (file_exists($filename2)) unlink($filename2);
		rename($filename, $filename2);
		touch($filename); chmod($filename,0666);
	}
	if (!is_writable($filename)) throw new Exception("Log file not writable. Please check permissions of file/directory");
	if (!$handle = fopen($filename, 'a')) throw new Exception("Unable to open the log file");
	if (fwrite($handle, $text) === FALSE) throw new Exception("Unable to write in the log file");
	fclose($handle);
}

function __file_backread_helper(&$haystack,$needle,$x) 
{ 
    $pos=0;$cnt=0;    
    while( $cnt < $x && ($pos=strpos($haystack,$needle,$pos)) !==false ){$pos++;$cnt++;}    
    return $pos==false ? false:substr($haystack,$pos,strlen($haystack)); 
} 

function __file_backread($file,$lines,&$fsize=0)
{ 
    $f=fopen($file,'r'); 
    if(!$f)return Array(); 


    $splits=$lines*50; 
    if($splits>10000)$splits=10000; 

    $fsize=filesize($file); 
    $pos=$fsize; 

    $buff1=Array(); 
    $cnt=0; 

    while($pos) 
    { 
        $pos=$pos-$splits; 

        if($pos<0){ $splits+=$pos; $pos=0;} 

        fseek($f,$pos); 
        $buff=fread($f,$splits); 
        if(!$buff)break; 

        $lines -= substr_count($buff, "\n"); 

        if($lines <= 0) 
        { 
            $buff1[] = __file_backread_helper($buff,"\n",abs($lines)+1); 
            break; 
        } 
        $buff1[] = $buff; 
    } 

    return str_replace("\r",'',implode('',array_reverse($buff1))); 
} 