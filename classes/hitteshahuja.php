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
 * Class file for tool_hitteshahuja
 * @package   tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_hitteshahuja;
defined('MOODLE_INTERNAL') || die();

/**
 * Class hitteshahuja
 * @package tool_hitteshahuja
 * @copyright 2020, hitteshahuja
 */
class hitteshahuja {
    /**
     * @var null
     */
    public $id = null;
    /**
     * @var $courseid
     */
    public $courseid;
    /**
     * @var
     */
    public $completed;
    /**
     * @var int
     */
    private $timecreated;
    /**
     * @var int
     */
    private $timemodified;
    /**
     * @var
     */
    public $name;


    /**
     * hitteshahuja constructor.
     * @param int $id
     */
    public function __construct(int $id) {
        $this->id = $id;
        $this->timecreated = $this->timemodified = time();
    }

    /**
     * Create an instance of the tool
     * @return hitteshahuja
     * @throws \dml_exception
     */
    public function create_tool_instance() {
        global $DB;
        if (isset($this->id) && $this->id !== 0) {
            $tooldata = $DB->get_record('tool_hitteshahuja', ['id' => $this->id]);
            $toolinstance = new \stdClass();
            $toolinstance->id = $this->id;
            $toolinstance->completed = $tooldata->completed;
            $toolinstance->timecreated = $tooldata->timecreated;
            $toolinstance->timemodified = $tooldata->timemodified;
            $toolinstance->name = $tooldata->name;
            $toolinstance->courseid = $tooldata->courseid;
        } else {
            $toolinstance = new \stdClass();
        }
        return $toolinstance;
    }

    /**
     * Get course for instance.
     * @param $courseid
     * @return bool|false|mixed|\stdClass
     * @throws \dml_exception
     */
    public function get_course_for_instance($courseid) {
        global $DB;
        return $DB->get_record('course', ['id' => $courseid]);
    }


    /**
     * Display all entries.
     * @param $url
     * @return mixed
     */
    public function display_all_entries($url) {
        global $PAGE;
        $output = $PAGE->get_renderer('tool_hitteshahuja');
        $renderable = new \tool_hitteshahuja\output\index_page($this->courseid, $url);
        return $output->render_index_page($renderable);
    }

    /**
     * Add a new tool entry
     * @param $data
     * @return bool|int
     * @throws \dml_exception
     */
    public static function add_entry($data) {
        global $DB;
        $data->timecreated = $data->timemodified = time();
        return $DB->insert_record('tool_hitteshahuja', $data);
    }

    /**
     * Update an existing entry.
     * @param $data
     * @return bool
     * @throws \dml_exception
     */
    public static function update_entry($data) {
        global $DB;
        return $DB->update_record('tool_hitteshahuja', $data);
    }

    /**
     * Delete an entry.
     * @param $entryid
     * @return bool
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws \require_login_exception
     */
    public static function delete_entry($entryid) {
        global $DB;
        $deleted = false;
        $record = $DB->get_record('tool_hitteshahuja', ['id' => $entryid], '*', MUST_EXIST);
        require_login(get_course($record->courseid));
        $coursecontext = \context_course::instance($record->courseid);
        if (has_capability('tool/hitteshahuja:edit', $coursecontext)) {
            if ($DB->delete_records('tool_hitteshahuja', ['id' => $entryid])) {
                $deleted = true;
            }
        }
        return $deleted;
    }

}