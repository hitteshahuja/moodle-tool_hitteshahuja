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

namespace tool_hitteshahuja\output;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/tablelib.php');

use coding_exception;
use context_helper;
use dml_exception;
use Exception;
use html_writer;
use pix_icon;
use stdClass;
use table_sql;

/**
 * Class display_table
 * @package tool_hitteshahuja\output
 */
class display_table extends table_sql {
    /**
     * @var array
     */
    public $headers = array();

    /**
     * display_table constructor.
     * @param $courseid
     * @throws coding_exception
     */
    public function __construct($courseid) {
        parent::__construct($courseid);
        // Define columns in the table.
        // Define headers and columns.
        $cols = array(
            'name' => get_string('name', 'tool_hitteshahuja'),
            'courseid' => get_string('courseid', 'tool_hitteshahuja'),
            'completed' => get_string('completed', 'tool_hitteshahuja'),
            'priority' => get_string('priority', 'tool_hitteshahuja'),
            'timecreated' => get_string('timecreated', 'tool_hitteshahuja'),
            'timemodified' => get_string('timemodified', 'tool_hitteshahuja'),
            'actions' => get_string('actions', 'tool_hitteshahuja')
        );
        $this->define_table_columns($cols);
        $this->define_table_headers($cols);

        $this->column_class('name', 'col-name');
        $this->column_class('completed', 'col-completed');
        $this->column_class('priority', 'col-priority');
        $this->column_class('timemodified', 'col-timecreated');
        $this->column_class('timemodified', 'col-timemodified');
        $this->column_class('actions', 'mdl-align col-actions');
        // Make this table sorted by first name by default.
        $this->sortable(true, 'timecreated');
        $this->no_sorting('actions');
        $totalcount = "SELECT COUNT(th.id)
            FROM {tool_hitteshahuja} th
            WHERE th.courseid = :courseid";
        $params = array('courseid' => $courseid);

        $this->set_count_sql($totalcount, $params);
        $this->set_sql('*', '{tool_hitteshahuja}', 'courseid = :courseid', ['courseid' => $courseid]);
    }

    /**
     * @param stdClass $row
     * @return string
     */
    public function col_completed(stdClass $row) {
        $o = '';
        if ($row->completed == "1") {
            $o = 'Yes';
        } else {
            $o = 'No';
        }
        return format_string($o);
    }

    /**
     * @param stdClass $row
     * @return string
     */
    public function col_priority(stdClass $row) {
        $o = '';
        if ($row->completed == "1") {
            $o = 'Yes';
        } else {
            $o = 'No';
        }
        return format_string($o);
    }

    /**
     * @param stdClass $row
     * @return string
     * @throws \moodle_exception
     * @throws \coding_exception
     */
    public function col_actions(stdClass $row) {
        // Prepare actions.
        $o = '';
        // Edit action.
        $editurl = new \moodle_url('/admin/tool/hitteshahuja/edit.php', ['id' => $row->id, 'courseid' => $row->courseid]);
        $o = html_writer::link($editurl, get_string('edit', 'tool_hitteshahuja'),
            ['data-id' => $row->id, 'data-courseid' => $row->courseid,
                'title' => get_string('edittitle', 'tool_hitteshahuja', format_string($row->name))]);
        $deleteurl = new \moodle_url('/admin/tool/hitteshahuja/edit.php', ['delete' => $row->id, 'sesskey' => sesskey()]);
        $o .= " ";
        $o .= html_writer::link($deleteurl, get_string('delete', 'tool_hitteshahuja'),
            ['class' => 'deletetool', 'data-id' => $row->id, 'data-courseid' => $row->courseid]);
        return $o;

    }

    /**
     * @param $row
     * @return string
     */
    public function col_timecreated($row) {
        $o = '-';
        if ($row->timecreated) {
            $o = userdate($row->timecreated);
        }
        return format_string($o);
    }

    /**
     * @param $row
     * @return string
     */
    public function col_timemodified($row) {
        $o = '-';
        if ($row->timemodified) {
            $o = userdate($row->timemodified);
        }
        return format_string($o);
    }

    /**
     * @param $cols
     */
    private function define_table_columns($cols) {
        $this->define_columns(array_keys($cols));
    }

    /**
     * @param $cols
     */
    private function define_table_headers($cols) {
        $this->define_headers(array_values($cols));
    }
}