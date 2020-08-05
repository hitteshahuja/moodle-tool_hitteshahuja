<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Services file for tool_hitteshahuja
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'tool_hitteshahuja_delete_entry' => array(
        'classname' => tool_hitteshahuja_external::class,
        'methodname' => 'delete_entry',
        'description' => 'Simulate deleting an entry',
        'type' => 'write',
        'capabilities' => 'tool/hitteshahuja:edit',
        'ajax' => true,
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'tool_hitteshahuja_show_template' => array(
        'classname' => tool_hitteshahuja_external::class,
        'methodname' => 'return_template_object',
        'description' => 'Returns Templateable Object',
        'type' => 'read',
        'capabilities' => 'tool/hitteshahuja:view',
        'ajax' => true,
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
    'tool_hitteshahuja_services' => array(
        'functions' => array ('tool_hitteshahuja_delete_entry', 'tool_hitteshahuja_show_template'),
        'restrictedusers' => 0,
        'enabled' => 1,
    )
);