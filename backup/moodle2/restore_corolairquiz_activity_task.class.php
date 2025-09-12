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
 * Restore task for the Corolair Quiz activity module.
 *
 * @package    mod_corolairquiz
 * @subpackage backup-moodle2
 * @copyright 2024 Corolair
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/corolairquiz/backup/moodle2/restore_corolairquiz_stepslib.php');

/**
 * Defines the restore task for the corolairquiz activity.
 *
 */
class restore_corolairquiz_activity_task extends restore_activity_task {

    /**
     * Define the settings for the corolairquiz activity.
     */
    protected function define_my_settings() {
        // No custom settings.
    }

    /**
     * Define the steps for the corolairquiz activity.
     */
    protected function define_my_steps() {
        $this->add_step(new restore_corolairquiz_activity_structure_step('corolairquiz_structure', 'corolairquiz.xml'));
    }

    /**
     * Define the decode contents for the corolairquiz activity.
     */
    public static function define_decode_contents() {
        return [];
    }

    /**
     * Define the decode rules for the corolairquiz activity.
     */
    public static function define_decode_rules() {
        return [];
    }
}
