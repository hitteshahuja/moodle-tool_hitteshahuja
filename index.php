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

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

use tool_hitteshahuja\output as output;

$id = optional_param('id', 1, PARAM_INT);
$course = $DB->get_record('course', ['id' => $id]);
$context = context_course::instance($course->id);
require_login($course);
require_capability('tool/hitteshahuja:view', $context);
$url = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $id]);
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'tool_hitteshahuja'));
$PAGE->set_heading(get_string('pluginname', 'tool_hitteshahuja'));
$output = $PAGE->get_renderer('tool_hitteshahuja');
echo $output->header();
echo $output->heading(get_string('pluginname', 'tool_hitteshahuja'));

/*$table = new \tool_hitteshahuja\output\display_table($id);
$table->baseurl = $url;
echo $table->out(50, true);*/
$renderable = new \tool_hitteshahuja\output\index_page($id, $url);
echo $output->render_index_page($renderable);
$editurl = new moodle_url('/admin/tool/hitteshahuja/edit.php', ['courseid' => $id]);
if (has_capability('tool/hitteshahuja:edit', $context)) {
    echo html_writer::link($editurl, get_string('add', 'tool_hitteshahuja'));
}
echo $output->footer();