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
 * Define all the backup steps that will be used by the backup_corolairquiz_activity_task
 *
 * @package    mod_corolairquiz
 * @copyright  2025 Raison
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Defines backup_corolairquiz_activity_task class
 *
 * @package     mod_corolairquiz
 * @category    backup
 * @copyright   2025 Raison
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class backup_corolairquiz_activity_structure_step
 * Defines the complete structure for backup of corolairquiz instances.
 */
class backup_corolairquiz_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the structure for the corolairquiz activity.
     *
     * @return backup_nested_element The structure for the corolairquiz activity.
     */
    protected function define_structure() {

        // Define the main element describing your activity.
        $corolairquiz = new backup_nested_element('corolairquiz', ['id'], [
            'name', 'timecreated', 'timemodified',
        ]);

        // If you have an intro field, add it here:
        // 'intro', 'introformat'.

        // Define data source.
        $corolairquiz->set_source_table('corolairquiz', ['id' => backup::VAR_ACTIVITYID]);

        // Define related files (e.g. intro attachments).
        $corolairquiz->annotate_files('mod_corolairquiz', 'intro', null);

        return $this->prepare_activity_structure($corolairquiz);
    }
}
