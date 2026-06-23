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
 * Count the views of the block.
 *
 * @package   block_foobar
 * @copyright (dummy)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_foobar\local\metrics;

use tool_monitoring\simple_metric_config;

/**
 * Defines the configuration for the `blocks_used` metric.
 */
class block_used_count_config extends simple_metric_config {
    /**
     * Simple constructor for blocks config field.
     * @param string $blocks
     */
    public function __construct(
        /**
         * @var $blocks
         * A List of blocks to check.
         */
        public string $blocks = '',
    ) {
    }
}
