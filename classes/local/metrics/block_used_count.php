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

use dml_exception;
use tool_monitoring\metric;
use tool_monitoring\metric_config;
use tool_monitoring\metric_type;
use tool_monitoring\metric_value;

/**
 * Implements the block_used_count metric.
 *
 * @package   block_foobar
 * @copyright (dummy)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_used_count extends metric
{
    /**
     * {@inheritDoc}
     */
    public function get_type(): metric_type {
        return metric_type::GAUGE;
    }

    /**
     * {@inheritDoc}
     * @param metric_config|null $config Metric configuration, if any.
     * @throws dml_exception
     */
    public function calculate(metric_config|null $config = null): array {
        global $DB;
        $returnrarray = [];

        // Note: first column must be unique.
        $sql = 'SELECT cs.category, COUNT(1) count FROM {block_instances} bi
                    LEFT JOIN {context} c ON bi.parentcontextid = c.id
                    LEFT JOIN {course} cs ON c.instanceid = cs.id
                    WHERE blockname="foobar"
                    GROUP BY cs.category';
        $res = $DB->get_records_sql($sql);

        foreach ($res as $row) {
            $returnrarray[] = new metric_value($row->count, ['category' => $row->category]);
        }
        return $returnrarray;
    }
}
