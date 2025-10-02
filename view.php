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

global $USER;

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('corolairquiz', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);

require_login($course, true, $cm);

// Trigger "module viewed" event.
$event = \mod_corolairquiz\event\course_module_viewed::create([
    'objectid' => $cm->instance,
    'context'  => $context,
]);
$event->trigger();

// Page setup.
$PAGE->set_url(new moodle_url('/mod/corolairquiz/view.php', ['id' => $id]));
// Attach the course module (important for nav).
$PAGE->set_cm($cm);
$PAGE->set_context($context);
$PAGE->set_title(format_string($cm->name));
$PAGE->set_heading(format_string($course->fullname));
// Show course navigation / breadcrumbs.
$PAGE->set_pagelayout('incourse');

require_capability('mod/corolairquiz:view', $context);

// Output header.
echo $OUTPUT->header();

if (!is_dir($CFG->dirroot . '/local/corolair')) {
    $output = $PAGE->get_renderer('mod_corolairquiz');
    echo $output->render_local_plugin_not_installed();
    echo $OUTPUT->footer();
    return;
}

// API key check.
$apikey = get_config('local_corolair', 'apikey');
if (empty($apikey) ||
    strpos($apikey, 'No Corolair Api Key') === 0 ||
    strpos($apikey, 'Aucune Clé API Corolair') === 0 ||
    strpos($apikey, 'No hay clave API de Corolair') === 0
) {
    $output = $PAGE->get_renderer('mod_corolairquiz');
    echo $output->render_local_plugin_not_installed();
    echo $OUTPUT->footer();
    return;
}


// If trainer (teacher/admin) → redirect to trainer page.
if (has_capability('moodle/course:manageactivities', $context)) {
    if (!has_capability('local/corolair:createtutor', context_system::instance(), $USER->id)) {
        throw new moodle_exception('missingcapability', 'local_corolair');
    }

    $createtutorwithcapability = get_config('local_corolair', 'createtutorwithcapability') === 'true';
    $authurl = "https://services.corolair.com/moodle-integration/auth/v2";
    $postdata = json_encode([
        'email' => $USER->email,
        'apiKey' => $apikey,
        'firstname' => $USER->firstname,
        'lastname' => $USER->lastname,
        'moodleUserId' => $USER->id,
        'createTutorWithCapability' => $createtutorwithcapability,
        'courseId' => (int)$course->id,
        'plugin' => 'corolairQuiz',
        'corolairQuizId' => $id,
    ]);
    $curl = new curl();
    $options = [
        "CURLOPT_RETURNTRANSFER" => true,
        'CURLOPT_HTTPHEADER' => [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postdata),
        ],
    ];
    $response = $curl->post($authurl, $postdata , $options);
    $errno = $curl->get_errno();
    // Handle the response.
    if ($response === false || $errno !== 0) {
        throw new moodle_exception('errortoken', 'local_corolair');
    }
    $jsonresponse = json_decode($response, true);
    // Validate the response.
    if (!isset($jsonresponse['url'])) {
        throw new moodle_exception('errortoken', 'local_corolair');
    }
    $targeturlresponse = $jsonresponse['url'];
        $targeturl = new moodle_url($targeturlresponse);
        $targeturlout = $targeturl->out(false);

        echo html_writer::div(
            html_writer::tag('p', get_string('redirectingmessage', 'local_corolair')) .
            html_writer::link(
                $targeturl,
                get_string('continue', 'moodle'),
                [
                    'target' => '_blank',
                    'class' => 'btn btn-primary',
                    'id'    => 'corolair-continue',
                ]
            ),
            'corolair-fallback',
            ['style' => 'margin-top:20px; text-align:center; width: 100%;']
        );
        $continueurl = $CFG->wwwroot . '/course/view.php?id=' . $course->id;
        // JS: try auto-open + handle manual click.
        echo html_writer::tag('script', "
            // Try to auto-open Corolair in a new tab
            var win = window.open('$targeturlout', '_blank');
            if (win && !win.closed && typeof win.closed != 'undefined') {
                // Auto-open worked: hide fallback
                var fb = document.getElementById('corolair-fallback');
                if (fb) fb.style.display = 'none';
                // Redirect Moodle tab home
                window.location.href = '" . $continueurl . "';
            }

            // If user clicks Continue manually
            var continueBtn = document.getElementById('corolair-continue');
            if (continueBtn) {
                continueBtn.addEventListener('click', function(e) {
                    // Redirect Moodle tab home after opening new tab
                    setTimeout(function() {
                        window.location.href = '" . $continueurl . "';
                    }, 500);
                });
            }
        ");

} else {
    // Otherwise: student view inline.
    // Student data.
    $data = [
        'email' => urlencode($USER->email),
        'apiKey' => urlencode($apikey),
        'firstName' => urlencode($USER->firstname),
        'lastName' => urlencode($USER->lastname),
        'moodleUserId' => urlencode($USER->id),
        'courseId' => urlencode($course->id),
        'corolairQuizId' => urlencode($id),
    ];

    // Render student view inline.
    $output = $PAGE->get_renderer('mod_corolairquiz');
    echo $output->render_quiz_student($data);
}
// Footer.
echo $OUTPUT->footer();
