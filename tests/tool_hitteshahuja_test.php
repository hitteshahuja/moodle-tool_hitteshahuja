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
 * Unit test file for hitteshahuja
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . '/admin/tool/hitteshahuja/classes/hitteshahuja.php');

/**
 * Class tool_hitteshahuja_testcase
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_hitteshahuja_testcase extends advanced_testcase {

    /**
     * Add entry test
     */
    public function test_add() {

    }

    /**
     * Update entry test
     */
    public function test_update() {

    }

    /**
     * Test delete entry method
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function test_delete() {
        global $DB;
        $this->resetAfterTest(true);
        $toolhitteshahuja = new stdClass();
        $course = $this->getDataGenerator()->create_course();
        $toolhitteshahuja->courseid = $course->id;
        $toolhitteshahuja->name = "Test Name";
        $toolhitteshahuja->completed = 1;
        $toolid = $DB->insert_record('tool_hitteshahuja', $toolhitteshahuja, true);
        $teacher = $this->getDataGenerator()->create_and_enrol($course, 'editingteacher');
        $this->setUser($teacher);
        // Try delete.
        $deleted = \tool_hitteshahuja\hitteshahuja::delete_entry($toolid);
        $this->assertTrue($deleted);
        $this->assertFalse($DB->record_exists('tool_hitteshahuja', ['id' => $toolid]));
    }
}