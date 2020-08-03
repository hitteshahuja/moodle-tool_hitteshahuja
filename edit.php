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
global $DB;

$id = optional_param('id', null, PARAM_INT); // Tool id.
$courseid = optional_param('courseid', null, PARAM_INT); // Course id.
$toolhitteshahuja = new tool_hitteshahuja\hitteshahuja($courseid, $id);
$instance = $toolhitteshahuja->create_tool_instance();
$course = $instance->get_course_for_instance($instance->courseid);
$indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $course->id]);
if ($deleteid = optional_param('delete', null, PARAM_INT)) {
    if (confirm_sesskey()) {
        if (\tool_hitteshahuja\hitteshahuja::delete_entry($deleteid)) {
            redirect($indexurl);
        }
    }
}
$context = context_course::instance($courseid);
require_login($course);
require_capability('tool/hitteshahuja:edit', $context);
$url = new moodle_url('/admin/tool/hitteshahuja/edit.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'tool_hitteshahuja'));
$PAGE->set_heading(get_string('edit', 'tool_hitteshahuja'));
$output = $PAGE->get_renderer('tool_hitteshahuja');
// Show the form.
// Load existing data.

$editform = new \tool_hitteshahuja\addentry(null, ['data' => $instance, 'courseid' => $courseid]);
// Form processing and displaying is done here.
$indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $courseid]);
if ($editform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form.
    redirect($indexurl);
} else if ($fromform = $editform->get_data()) {
    // Handle form processing.
    if ($fromform->id) {
        // Update.
        $toolhitteshahuja::update_entry($fromform);
        redirect($indexurl);
    } else {
        $instance->courseid = $fromform->courseid;
        $instance->name = $fromform->name;
        $instance->completed = $fromform->completed;
        if ($toolhitteshahuja->add_entry($instance)) {
            $indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $courseid]);
            // Data was saved. return to index page.
            redirect($indexurl);
        }
    }

} else {
    echo $output->header();
    // Displays the form.
    $editform->set_data($instance);
    $editform->display();
}
echo $output->footer();