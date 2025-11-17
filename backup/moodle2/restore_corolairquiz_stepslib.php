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
 * Structure step to restore one corolairquiz activity.
 *
 * @package    mod_corolairquiz
 * @subpackage backup-moodle2
 * @copyright 2025 Raison
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Structure step to restore one corolairquiz activity.
 *
 */
class restore_corolairquiz_activity_structure_step extends restore_activity_structure_step {

    /**
     * Define the structure for the corolairquiz activity.
     *
     * @return array The structure for the corolairquiz activity.
     */
    protected function define_structure() {
        $paths = [];
        $paths[] = new restore_path_element('corolairquiz', '/activity/corolairquiz');
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Process the corolairquiz activity.
     *
     * @param array $data The data from the activity.
     */
    protected function process_corolairquiz($data) {
        global $DB;
        $data = (object)$data;
        $data->course = $this->get_courseid();

        // Insert record into DB.
        $newitemid = $DB->insert_record('corolairquiz', $data);

        // Apply activity instance mapping.
        $this->apply_activity_instance($newitemid);
    }

    /**
     * After execute.
     */
    protected function after_execute() {
        // Restore intro files if present.
        $this->add_related_files('mod_corolairquiz', 'intro', null);
    }
}
