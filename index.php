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
 * Activity index for the mod_corolairquiz plugin.
 *
 * @package   mod_corolairquiz
 * @copyright  2024 Corolair
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', ['id' => $id], '*', MUST_EXIST);
require_course_login($course);

// Trigger module instance list viewed event.
$params = [
    'context' => context_course::instance($course->id),
];

$event = \mod_corolairquiz\event\course_module_instance_list_viewed::create($params);
$event->add_record_snapshot('course', $course);
$event->trigger();

$PAGE->set_url('/mod/corolairquiz/index.php', ['id' => $id]);
$PAGE->set_pagelayout('incourse');
$PAGE->set_title(get_string('modulenameplural', 'mod_corolairquiz'));
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('modulenameplural', 'mod_corolairquiz'));
$modinfo = get_fast_modinfo($course);
$instances = $modinfo->get_instances_of('corolairquiz');
if (empty($instances)) {
    echo get_string('noinstances', 'mod_corolairquiz');
} else {
    echo html_writer::start_tag('ul');
    foreach ($instances as $cm) {
        $url = new moodle_url('/mod/corolairquiz/view.php', ['id' => $cm->id]);
        echo html_writer::tag('li', html_writer::link($url, $cm->name));
    }
    echo html_writer::end_tag('ul');
}
echo $OUTPUT->footer();
