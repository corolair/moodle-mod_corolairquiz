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
 * Activity view page for the mod_corolairquiz plugin.
 *
 * @package    mod_corolairquiz
 * @copyright  2024 Corolair
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');
$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('corolairquiz', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);
require_login($course, true, $cm);

// Trigger module viewed event.
$event = \mod_corolairquiz\event\course_module_viewed::create([
    'objectid' => $cm->instance,
    'context'  => $context,
]);
$event->trigger();

echo $OUTPUT->header();
if (!is_dir($CFG->dirroot . '/local/corolair')) {
    $output = $PAGE->get_renderer('mod_corolairquiz');
    echo $output->render_local_plugin_not_installed();
    echo $OUTPUT->footer();
    return;
}
require_capability('mod/corolairquiz:view', $context);

// Redirect based on role.
if (has_capability('moodle/course:manageactivities', $context)) {
    // Teacher or editingteacher.
    redirect(
        new moodle_url("/local/corolair/quiz_trainer.php", ['corolairquizid' => $id, 'courseid' => $course->id]),
        '',
        0
    );
} else {
    // Student view.
    redirect(
        new moodle_url("/local/corolair/quiz_student.php", ['corolairquizid' => $id, 'courseid' => $course->id]),
        '',
        0
    );
}



