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
    public static function delete_entry($id) {
        $params = self::validate_parameters(self::delete_entry_parameters(),
            array(
                'entryid' => $id
            ));
        $entryid = $params['entryid'];
        return ['deleted' => \tool_hitteshahuja\hitteshahuja::delete_entry($entryid)];
    }

    /**
     * Delete an entry parameters
     * @return \external_function_parameters
     */
    public static function delete_entry_parameters(): external_function_parameters {
        return new \external_function_parameters(
            array('entryid' => new \external_value(PARAM_INT, 'Entry ID', VALUE_REQUIRED))
        );

    }

    /**
     * Return value when deleting an entry
     * @return \external_single_structure
     */
    public static function delete_entry_returns() {
        return new \external_single_structure(
            array(
                'deleted' => new \external_value(PARAM_BOOL, 'Deleted ?'),
            )
        );
    }

    /**
     * @param $courseid
     * @return array
     * @throws coding_exception
     */
    public static function return_template_object($courseid) {
        global $PAGE;
        $params = self::validate_parameters(self::return_template_object_parameters(),
            array(
                'courseid' => $courseid
            ));
        $id = $params['courseid'];
        $output = $PAGE->get_renderer('tool_hitteshahuja');
        $url = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $id]);
        $outputpage = new index_page($courseid, $url);
        return ['content' => json_encode($outputpage->export_for_template($output))];
    }

    /**
     * @return external_function_parameters
     */
    public static function return_template_object_parameters() {
        return new \external_function_parameters(
            array('courseid' => new \external_value(PARAM_INT, 'Course ID'))
        );
    }

    /**
     * @return external_single_structure
     */
    public static function return_template_object_returns() {
        return new external_single_structure(
            array(
                'content' => new external_value(PARAM_RAW, 'JSON-encoded data for template', VALUE_OPTIONAL)
            )
        );

    }
}