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
namespace block_site_stats\output;

use advanced_testcase;
use block_site_stats\task\diskusage;
/**
 * PHPUnit block_site_stats tests
 *
 * @package    block_site_stats
 * @category   test
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \block_site_stats\output\main
 */
final class main_test extends advanced_testcase {
    /**
     * Assigns the main class instance
     * @var main main class instance
     */
    private $main;
    /**
     * Initial Setup
     * @return void
     */
    public function setUp(): void {
        $this->resetAfterTest();
        $this->setAdminUser();
        $this->main = new main();
    }
    /**
     * Ensures get_users_count() returns correct data
     * @return void
     */
    public function test_get_users_count(): void {
        // Test when new users are not created.
        $usercount = $this->main->get_users_count();
        $this->assertEquals(1, $usercount);

        // Test when new users are created.
        $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->create_user();
        $usercount = $this->main->get_users_count();
        $this->assertEquals(4, $usercount);
    }
    /**
     * Ensures get_courses_count() returns correct data
     * @return void
     */
    public function test_get_courses_count(): void {
        // Test when no courses created.
        $coursecount = $this->main->get_courses_count();
        $this->assertEquals(0, $coursecount);

        // Test when new courses are created.
        $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->create_course();
        $coursecount = $this->main->get_courses_count();
        $this->assertEquals(2, $coursecount);
    }
    /**
     * Ensures get_activities_count() returns correct data
     * @return void
     */
    public function test_get_activities_count(): void {
        // Test when no activities are created.
        $activitycount = $this->main->get_activities_count();
        $this->assertEquals(0, $activitycount);

        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->create_module('assign', ['course' => $course->id]);
        $this->getDataGenerator()->create_module('quiz', ['course' => $course->id]);
        $this->getDataGenerator()->create_module('forum', ['course' => $course->id]);
        $this->getDataGenerator()->create_module('feedback', ['course' => $course->id]);
        // Test when activities are created.
        $activitycount = $this->main->get_activities_count();
        $this->assertEquals(4, $activitycount);
    }
    /**
     * Ensures get_disk_usage() returns correct data
     * @return void
     */
    public function test_get_disk_usage(): void {
        // Test when the diskusage scheduled task is not run.
        $diskusage = $this->main->get_disk_usage();
        $expected = get_string('notcalculated', 'block_site_stats');
        $this->assertEquals($expected, $diskusage);

        // Test when the diskusage scheduled task is run.
        $task = new diskusage();
        $status = $task->execute();
        if ($status) {
            $diskusage = $this->main->get_disk_usage();
            $this->assertNotEquals($expected, $diskusage);
        }
    }
}
