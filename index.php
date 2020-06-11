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
admin_externalpage_setup('toolhitteshahuja');
$id = optional_param('id', 1, PARAM_INT);
$url = new moodle_url('/admin/tool/hitteshahuja/index.php', ['id' => $id]);
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'tool_hitteshahuja'));
$PAGE->set_heading(get_string('pluginname', 'tool_hitteshahuja'));
$output = $PAGE->get_renderer('tool_hitteshahuja');
echo $output->header();
echo $output->heading(get_string('pluginname', 'tool_hitteshahuja'));
$renderable = new \tool_hitteshahuja\output\index_page('Hello World');
echo $output->render($renderable);
echo get_string("helloworld", "tool_hitteshahuja", $id);
echo $output->footer();