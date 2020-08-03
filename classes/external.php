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
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/externallib.php');

use tool_hitteshahuja\output\index_page;

/**
 * Class tool_hitteshahuja_external
 * @package tool_hitteshahuja\external
 */
class tool_hitteshahuja_external extends \external_api {
    /**
     * Delete entry
     */
    public static function delete_entry($id) : external_function_parameters {
        $params = self::validate_parameters(self::delete_entry_parameters(),
            array(
                'id' => $id
            ));
        $entryid = $params['id'];
        return hitteshahuja::delete_entry($entryid);
    }

    /**
     * @return \external_function_parameters
     */
    public static function delete_entry_parameters() {
        return new \external_function_parameters(
            array('entryid' => new \external_value(PARAM_INT, 'Entry ID'))
        );

    }

    /**
     * @return \external_function_parameters
     */
    public static function delete_entry_returns() {
        return new \external_function_parameters(
            array(
                'deleted' => new \external_value(PARAM_BOOL, 'Deleted ?'),
            )
        );
    }

    public static function return_template_object($courseid) {
        global $PAGE;
        $output = $PAGE->get_renderer('tool_hitteshahuja');
        $outputpage = new index_page($courseid);
        return ['content' => $outputpage->export_for_template($output)];

    }

    public static function return_template_object_parameters() {
        return new \external_function_parameters(
            array('courseid' => new \external_value(PARAM_INT, 'Course ID'))
        );
    }

    public static function return_template_object_returns() {
        return new external_single_structure(
            array(
                'content' => new external_value(PARAM_RAW, 'JSON-encoded data for template', VALUE_OPTIONAL),
            )
        );
    }
}