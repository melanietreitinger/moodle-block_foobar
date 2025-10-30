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
 * Foobar block.
 *
 * @package   block_foobar
 * @copyright (dummy)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Foobar block class.
 *
 * @package   block_foobar
 * @copyright (dummy)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_foobar extends block_list
{
    /**
     * Init function
     *
     * @return void
     * @throws coding_exception
     */
    public function init(): void {
        $this->title = get_string('foobar', 'block_foobar');
    }

    /**
     * Where the block can be used.
     *
     * @return array[]
     */
    public function applicable_formats(): array {
        return ['site' => true, 'course' => true];
    }

    /**
     * Display the content of the block.
     *
     * @return stdClass|null
     */
    public function get_content(): ?stdClass {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = [];
        $this->content->icons = [];
        $this->content->footer = '<i>The usage of this block is counted by tool_monitoring.</i>';

        $courseid = $this->page->course->id;
        if ($courseid <= 0) {
            $courseid = SITEID;
        }

        if (empty($this->instance->pageid)) {
            $this->instance->pageid = SITEID;
        }

        $this->content->items[] = 'This is courseid "' . $courseid . '".';

        return $this->content;
    }
}
