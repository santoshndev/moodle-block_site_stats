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
 * Class containing data for Site Statistics block.
 *
 * @package    block_site_stats
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_site_stats\output;
defined('MOODLE_INTERNAL') || die();

use moodle_url;
use renderer_base;

class main implements \templatable, \renderable {
    private $cache;

    /**
     * Constructor
    */
    public function __construct() {
        $this->cache = \cache::make('block_site_stats', 'sitestats');
    }
    /**
     * Get the total count of users
     * @return int count of users
     */
    public function get_users_count() {
        global $DB;
        $userscountcache = $this->cache->get('userscount');
        if (!$userscountcache) {
            $userscount = $DB->count_records('user', ['deleted' => 0, 'suspended' => 0]) - 1;
            $this->cache->set('userscount', $userscount);
            return $userscount;
        }
        return $userscountcache;
    }
    /**
     * Get the total count of courses
     * @return int count of courses
    */
    public function get_courses_count() {
        global $DB;
        $coursescountcache = $this->cache->get('coursescount');
        if (!$coursescountcache) {
            $coursescount = $DB->count_records('course') - 1;
            $this->cache->set('coursescount', $coursescount);
            return $coursescount;
        }
        return $coursescountcache;
    }
    /**
     * Get the total count of activities
     * @return int count of activities
     */
    public function get_activities_count() {
        global $DB;
        $activitiescountcache = $this->cache->get('activitiescount');
        if (!$activitiescountcache) {
            $activitiescount = $DB->count_records('course_modules');
            $this->cache->set('activitiescount', $activitiescount);
            return $activitiescount;
        }
        return $activitiescountcache;
    }
    /**
     * Returns the total of disk usage
     *
     * @return string disk usage
     * @throws \coding_exception
     */
    public function get_disk_usage() {
        $diskusagecache = $this->cache->get('diskusage');

        if (!$diskusagecache) {
            return get_string('notcalculated', 'block_site_stats');
        }

        $unit = ' MB';
        if ($diskusagecache > 1024) {
            $unit = ' GB';
        }

        return $diskusagecache . $unit;
    }
    /**
     * Export the data for template
     */
    public function export_for_template(renderer_base $output) {
        $userurl = new moodle_url('/admin/user.php');
        $courseurl = new moodle_url('/course/index.php');
        $activityurl = new moodle_url('/admin/modules.php');
        $templatecontext = [
            'userscount' => $this->get_users_count(),
            'coursescount' => $this->get_courses_count(),
            'activitiescount' => $this->get_activities_count(),
            'diskusage' => $this->get_disk_usage(),
            'userurl' => $userurl->out(),
            'courseurl' => $courseurl->out(),
            'activityurl' => $activityurl->out(),
        ];
        return $templatecontext;
    }

}
