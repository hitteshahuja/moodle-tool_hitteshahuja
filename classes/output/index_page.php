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
class index_page implements renderable, templatable {
    private $helloworld;

    /**
     * index_page constructor.
     * @param $helloworld
     */
    public function __construct($helloworld) {
        $this->helloworld = $helloworld;
    }

    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->helloworld = $this->helloworld;
        return $data;
    }
}