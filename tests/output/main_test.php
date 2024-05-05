<?php

namespace block_site_stats\output;

use block_site_stats\task\diskusage;

class main_test extends \advanced_testcase {
    private $main;
    /**
     * Initial Setup
    */
    public function setUp(): void {
        $this->resetAfterTest();
        $this->setAdminUser();
        $this->main = new main();
    }
    /**
     * Ensures get_users_count() returns correct data
    */
    public function test_get_users_count() {
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
     */
    public function test_get_courses_count() {
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
     */
    public function test_get_activities_count() {
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
     */
    public function test_get_disk_usage() {
        global $CFG;
        // Test when the diskusage scheduled task is not run.
        $diskusage = $this->main->get_disk_usage();
        $expected = get_string('notcalculated', 'block_site_stats');
        $this->assertEquals($expected, $diskusage);

        // Test when the diskusage scheduled task is run.
        $diskusage = get_directory_size($CFG->dataroot);
        $disksize = number_format(ceil($diskusage / 1048576));
        $task = new diskusage();
        $status = $task->execute();
        if ($status) {
            $diskusage = $this->main->get_disk_usage();
            $this->assertEquals($disksize . ' MB', $diskusage);
        }
    }
}
