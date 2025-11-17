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
 * Defines backup_corolairquiz_activity_task class
 *
 * @package     mod_corolairquiz
 * @category    backup
 * @copyright   2025 Raison
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/corolairquiz/backup/moodle2/backup_corolairquiz_stepslib.php');

/**
 * Defines the backup task for the corolairquiz activity.
 *
 * @package   mod_corolairquiz
 */
class backup_corolairquiz_activity_task extends backup_activity_task {

    /**
     * Define the backup settings for the corolairquiz activity.
     */
    protected function define_my_settings() {
        // No specific settings required.
    }

    /**
     * Define the backup steps for the corolairquiz activity.
     */
    protected function define_my_steps() {
        $this->add_step(new backup_corolairquiz_activity_structure_step('corolairquiz_structure', 'corolairquiz.xml'));
    }

    /**
     * Encode the content links for the corolairquiz activity.
     *
     * @param string $content The content to encode.
     * @return string The encoded content.
     */
    public static function encode_content_links($content) {
        global $CFG;
        $base = preg_quote($CFG->wwwroot, '/');

        // Replace links to view.php with placeholders.
        $search = "/(".$base."\/mod\/corolairquiz\/view.php\?id=)([0-9]+)/";
        $content = preg_replace($search, '$@COROLAIRQUIZVIEWBYID*$2@$', $content);

        return $content;
    }
}
