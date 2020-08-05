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
 * @package   plugintype_pluginname
 * @copyright 2020, hitteshahuja
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_hitteshahuja\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use stdClass;
use tool_hitteshahuja\hitteshahuja;

/**
 * Class index_page
 * @package tool_hitteshahuja\output
 */
class index_page implements renderable, templatable {
    /**
     * @var
     */
    private $courseid;
    /**
     * @var
     */
    private $url;

    /**
     * index_page constructor.
     * @param $courseid
     * @param $url
     */
    public function __construct($courseid, $url) {
        $this->courseid = $courseid;
        $this->url = $url;
    }

    /**
     * Display table
     * @param renderer_base $output
     * @return stdClass
     * @throws \coding_exception|\moodle_exception
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $o = '';
        $toolhitteshahuja = new hitteshahuja($this->courseid);
        $editurl = new \moodle_url('/admin/tool/hitteshahuja/edit.php', ['courseid' => $this->courseid]);

        ob_start();
        $table = new \tool_hitteshahuja\output\display_table($this->courseid);
        $table->baseurl = $this->url;
        $tableout = $table->out(50, true);
        if ($toolhitteshahuja->is_editable()) {
            $data->button = \html_writer::link($editurl, get_string('add', 'tool_hitteshahuja'),
            ['class' => 'btn btn-primary']);
        }
        $o .= ob_get_contents();
        ob_end_clean();
        $data->table = $o;

        return $data;

    }
}