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

$id = optional_param('id', '', PARAM_INT); // Tool id.
$courseid = optional_param('courseid', '', PARAM_INT); // Course id.

if ($id) {
    $tooldata = $DB->get_record('tool_hitteshahuja', ['id' => $id]);
    $course = $DB->get_record('course', ['id' => $tooldata->courseid]);
} else {
    $tooldata = new stdClass();
    $tooldata->id = null;
}
if (isset($courseid) && !empty($courseid)) {
    $course = $DB->get_record('course', ['id' => $courseid]);
}
if ($deleteid = optional_param('delete', null, PARAM_INT)) {
    if (confirm_sesskey()) {
        $record = $DB->get_record('tool_hitteshahuja', ['id' => $deleteid], '*', MUST_EXIST);
        require_login(get_course($record->courseid));
        require_capability('tool/hitteshahuja:edit', context_course::instance($record->courseid));
        $DB->delete_records('tool_hitteshahuja', ['id' => $deleteid]);
        $indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $record->courseid]);
        redirect($indexurl);
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

$editform = new \tool_hitteshahuja\addentry(null, ['data' => $tooldata, 'courseid' => $courseid]);
// Form processing and displaying is done here.
$indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $courseid]);
if ($editform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form.
    redirect($indexurl);
} else if ($fromform = $editform->get_data()) {
    // Handle form processing.
    if ($fromform->id) {
        // Update.
        $DB->update_record('tool_hitteshahuja', $fromform);
        redirect($indexurl);
    } else {
        $newdata = new stdClass();
        $newdata->courseid = $fromform->courseid;
        $newdata->name = $fromform->name;
        $newdata->completed = $fromform->completed;
        $newdata->timemodified = time();
        $newdata->timecreated = time();
        $DB->insert_record('tool_hitteshahuja', $newdata);
        $indexurl = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $newdata->courseid]);
        // Data was saved. return to index page.
        redirect($indexurl);
    }

} else {
    echo $output->header();
    // Displays the form.
    $editform->set_data($tooldata);
    $editform->display();
}
echo $output->footer();