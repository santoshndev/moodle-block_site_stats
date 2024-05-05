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
namespace block_site_stats\privacy;

use advanced_testcase;
/**
 * PHPUnit block_site_stats tests
 *
 * @package    block_site_stats
 * @category   test
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \block_site_stats\privacy\provider
 */
class provider_test extends advanced_testcase {
    /**
     * Ensures test_get_reason() returns correct data
     */
    public function test_get_reason() {
        $this->resetAfterTest();
        $this->setAdminUser();
        $privacy = new provider();
        $expected = 'privacy:metadata';
        $this->assertEquals($expected, $privacy->get_reason());
    }
}
