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

interface AbstractPluginControlDescriptor extends AbstractPluginDescriptor
{
    /** Returns TRUE, FALSE or trigger an exception. When an exception is triggered the result
     * is considered as a FALSE result. */
    public function testControl();
    
    /** Load a content for this control descriptor by using the code as stored in database.
     * This is the same value returned by the storeConfig() call.
     */
    public function loadConfig($configCode);
    
    /** Saves a content for this control descriptor by using the array of POST values set
     * by the user with the form.
     */
    public function storeForm($array);
    
    /** Prepares a config code to be stored into database. */
    public function storeConfig();

    /** Returns an array showing the form fields to show.
     * The array must be filled with objects like this:
     * { id => "", typeField => "textarea", defaultValue => "", "currentValue" => "" }
     */
    public function loadForm();
}
