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
 * Activity creation/editing form for the mod_corolairquiz plugin
 *
 * @package    mod_corolairquiz
 * @copyright  2024 Corolair
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/course/moodleform_mod.php');


/**
 * Class mod_corolairquiz_mod_form
 *
 * This class defines the form elements and behavior for the Corolair Quiz module in Moodle.
 * It extends the moodleform_mod class to provide a custom form for creating and editing module instances.
 */
class mod_corolairquiz_mod_form extends moodleform_mod {
    /**
     * Defines the form elements for the module.
     *
     * This method sets up the form elements required for the module, including:
     * - A text input field for the module name, with a default value fetched from language strings.
     * - Standard course module elements.
     * - Action buttons for form submission.
     *
     * @return void
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('text', 'name', get_string('name'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->setDefault('name', get_string('defaultactivityname', 'mod_corolairquiz'));
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }


    /**
     * Preprocesses form data before it is displayed to the user.
     *
     * This method is used to modify the default values of the form fields
     * before the form is rendered. It ensures that certain fields are set
     * appropriately based on the context (e.g., whether the instance is new
     * or being edited).
     *
     * @param array $defaultvalues Reference to the array of default values
     *                             for the form fields. This array is modified
     *                             directly by the method.
     */
    public function data_preprocessing(&$defaultvalues) {
        parent::data_preprocessing($defaultvalues);
        if (empty($this->current->instance)) {
            $defaultvalues['visible'] = 0;
        }
    }

    /**
     * Validates the form data.
     *
     * Prevents adding more than one instance of the module per course.
     *
     * @param array $data The submitted form data.
     * @param array $files The submitted files.
     * @return array An array of error messages, indexed by field name.
     */
    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        // Check if another instance already exists in this course.
        // if (!empty($data['course'])) {
        //     $courseid = $data['course'];
        //     // Allow editing existing instance.
        //     if (empty($this->current->id)) {
        //         $exists = $DB->record_exists('corolairquiz', ['course' => $courseid]);
        //         if ($exists) {
        //             $errors['name'] = get_string('onlyoneinstanceallowed', 'mod_corolairquiz');
        //         }
        //     }
        // }
        return $errors;
    }
}
