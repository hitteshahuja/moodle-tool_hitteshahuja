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
 * Lib file for tool hitteshahuja
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Navigation on this page is only shown when you are in the plugin context.
/**
 * Navigation on this page is only shown when you are in the plugin context.
 * @param stdClass $navigation
 * @param stdClass $course
 * @param context $context
 * @throws coding_exception
 * @throws moodle_exception
 */
function tool_hitteshahuja_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('tool/hitteshahuja:view', $context)) {
        $navigation->add(get_string('pluginname', 'tool_hitteshahuja'),
            new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $course->id]), navigation_node::TYPE_SETTING
            , null, null, new pix_icon('icon', '', 'tool_hitteshahuja'));
    }
}

