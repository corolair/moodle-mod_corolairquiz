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
 * This file contains the core functions for the mod_corolairquiz module.
 *
 * @package    mod_corolairquiz
 * @copyright  2025 Raison
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the features supported for corolairquiz plugin.
 *
 * @param string $feature The feature to check support for.
 * @return bool|null True if feature is supported, false if not, or null if unknown.
 */
function corolairquiz_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_corolairquiz into the database.
 *
 * @param object $moduleinstance An object from the form (has course, name, intro, etc.)
 * @param moodleform|null $mform The form instance (not used here).
 * @return int The ID of the newly inserted record.
 */
function corolairquiz_add_instance($moduleinstance, $mform = null): int {
    global $DB;
    $moduleinstance->timecreated = time();
    $moduleinstance->timemodified = $moduleinstance->timecreated;
    $id = $DB->insert_record('corolairquiz', $moduleinstance);
    return $id;
}


/**
 * Updates an existing instance of the corolairquiz module.
 *
 * @param object $instancedata Data from the form.
 * @param moodleform $mform The form.
 * @return bool True on success.
 */
function corolairquiz_update_instance($instancedata, $mform): bool {
    global $DB;
    $record = new stdClass();
    $record->id = $instancedata->instance;
    $record->name = $instancedata->name;
    $record->timemodified = time();
    return $DB->update_record('corolairquiz', $record);
}


/**
 * Deletes an instance of the corolairquiz module.
 *
 * @param int $id The ID of the instance to delete.
 * @return bool True on success.
 */
function corolairquiz_delete_instance($id): bool {
    global $DB;
    if (!$instance = $DB->get_record('corolairquiz', ['id' => $id])) {
        return false;
    }
    $DB->delete_records('corolairquiz', ['id' => $id]);
    return true;
}
