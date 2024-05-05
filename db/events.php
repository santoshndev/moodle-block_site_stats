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
 * This file defines observers needed by the site stats block.
 *
 * @package    block_site_stats
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
// List of observers.
$observers = [
    [
        'eventname' => '\core\event\user_created',
        'callback' => '\block_site_stats\observer::user_created',
    ],
    [
        'eventname' => '\core\event\user_deleted',
        'callback' => '\block_site_stats\observer::user_deleted',
    ],
    [
        'eventname' => '\core\event\course_deleted',
        'callback' => '\block_site_stats\observer::course_deleted',
    ],
    [
        'eventname' => '\core\event\course_created',
        'callback' => '\block_site_stats\observer::course_created',
    ],
    [
        'eventname' => '\core\event\course_module_created',
        'callback' => '\block_site_stats\observer::module_created',
    ],
    [
        'eventname' => '\core\event\course_module_deleted',
        'callback' => '\block_site_stats\observer::module_deleted',
    ],
];
