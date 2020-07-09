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

namespace tool_hitteshahuja;
use coding_exception;
use dml_exception;

defined('MOODLE_INTERNAL') || die();
require_once("$CFG->libdir/formslib.php");

class addentry extends \moodleform {

    /**
     * Form definition. Abstract method - always override!
     */
    protected function definition() {
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!
        $data = $this->_customdata['data'];
        $courseid = $this->_customdata['courseid'];
        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_ALPHANUMEXT);
        $mform->addElement('advcheckbox', 'completed', get_string('completed', 'tool_hitteshahuja'),
            'Completed', array('group' => 1), array(0, 1));
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);
        $this->add_action_buttons(true, get_string('add', 'tool_hitteshahuja'));

    }

    // Custom validation should be added here.

    /**
     * @param array $data
     * @param array $files
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        if (isset($data['name']) && !isset($data['id'])) {
            $coursename = $data['name'];
            if ($DB->record_exists('tool_hitteshahuja', ['name' => $coursename])) {
                // Throw error.
                $errors['name'] = get_string('namealreadyinuse', 'tool_hitteshahuja');
            }
        }
        return $errors;
    }
}