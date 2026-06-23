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

use coding_exception;
use dml_exception;
use tool_monitoring\metric_config;
use tool_monitoring\metric_type;
use tool_monitoring\metric_value;
use tool_monitoring\metric_with_config;

/**
 * Implements the block_used_count metric.
 *
 * @package   block_foobar
 * @copyright (dummy)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_used_count extends metric_with_config
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
     * @throws dml_exception|coding_exception
     */
    public function calculate(metric_config|null $config = null): array {
        global $DB;
        $values = [];
        $insql = 'IS NOT NULL';
        $params = [];

        if (!empty($config->blocks)) {
            $blocklist = explode(',', $config->blocks);
            $blocklist = array_map('trim', $blocklist);
            [$insql, $params] = $DB->get_in_or_equal($blocklist);
        } else {
            $blocklist = $DB->get_fieldset_select('block', 'name', 'visible = 1');
        }

        $sql = "SELECT b.name,
                       COUNT(DISTINCT binst.id) AS count
                  FROM {block} AS b
             LEFT JOIN {block_instances} AS binst ON binst.blockname = b.name
                WHERE b.name $insql
              GROUP BY b.name";

        $records = $DB->get_records_sql($sql, $params);

        foreach ($blocklist as $b) {
            if (!isset($records[$b])) {
                continue;
            }
            $values[] = new metric_value($records[$b]->count, ['name' => $b]);
        }

        return $values;
    }

    #[\Override]
    public function get_default_config(): block_used_count_config {
        return new block_used_count_config();
    }
}
