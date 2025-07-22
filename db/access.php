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
 * Capability definitions for the Corolair Quiz plugin.
 *
 * This file contains the capability definitions for the Corolair Quiz plugin.
 * Capabilities are used to control access to various features within the plugin.
 *
 * @package    mod_corolairquiz
 * @copyright  2024 Corolair
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    // Capability to view and access quizzes within the Corolair Quiz plugin.
    // This capability allows users to create and manage quizzes within the Corolair Quiz plugin.
    // @captype      read
    // @contextlevel CONTEXT_MODULE
    // @description  Allows users to create and manage quizzes within the Corolair Quiz plugin.
    'mod/corolairquiz:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => [
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
        'description' => get_string('corolairquiz:view', 'mod_corolairquiz'),
    ],
    // Capability to add Corolair Quiz plugin as an activity.
    // This capability allows users to create an activity using Corolair Quiz plugin.
    // @captype      write
    // @contextlevel CONTEXT_COURSE
    // @description  Allows users to create an activity using Corolair Quiz plugin.
    'mod/corolairquiz:addinstance' => [
        'riskbitmask' => RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ],
        'clonepermissionsfrom' => 'moodle/course:manageactivities',
        'description' => get_string('corolairquiz:addinstance', 'mod_corolairquiz'),
    ],
];
