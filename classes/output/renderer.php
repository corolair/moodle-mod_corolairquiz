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
 * Renderer class for the mod_corolairquiz plugin.
 *
 * This class extends the plugin_renderer_base and provides methods to render
 * custom templates for the mod_corolairquiz plugin.
 *
 * @package    mod_corolairquiz
 * @copyright  2024 Corolair
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_corolairquiz\output;

use plugin_renderer_base;

/**
 * Class renderer
 *
 * This class is responsible for rendering templates for the mod_corolairquiz plugin.
 */
class renderer extends plugin_renderer_base {

    /**
     * Renders the embed template when related corolair_local plugin not installed.
     *
     * This method renders the 'mod_corolairquiz/local_plugin_not_installed' template.
     *
     * @return string The rendered template.
     */
    public function render_local_plugin_not_installed() {
        $data = [];
        return $this->render_from_template('mod_corolairquiz/local_plugin_not_installed', $data);
    }

    /**
     * Renders the quiz student template.
     *
     * This method prepares the data and renders the 'mod_corolairquiz/quiz_student' template.
     *
     * @param string $moodleoptions The Moodle options.
     * @return string The rendered template.
     */
    public function render_quiz_student($moodleoptions) {
        // Pass each field individually to the template for direct access.
        return $this->render_from_template('mod_corolairquiz/quiz_student', $moodleoptions);
    }

}
