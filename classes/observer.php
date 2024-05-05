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

namespace block_site_stats;

use cache;
/**
 * The observer class needed by the site stats block.
 *
 * @package    block_site_stats
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {

    /**
     * Clears userscount cache on user_created event
     */
    public static function user_created($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('userscount');
    }
    /**
     * Clears userscount cache on user_deleted event
     */
    public static function user_deleted($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('userscount');
    }
    /**
     * Clears coursescount cache on course_created event
     */
    public static function course_created($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('coursescount');
    }
    /**
     * Clears coursescount cache on course_deleted event
     */
    public static function course_deleted($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('coursescount');
    }
    /**
     * Clears activitiescount cache on course_module_created event
     */
    public static function module_created($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('activitiescount');
    }
    /**
     * Clears activitiescount cache on course_module_deleted event
     */
    public static function module_deleted($event) {
        $cache = cache::make('block_site_stats', 'sitestats');
        $cache->delete('activitiescount');
    }
}
