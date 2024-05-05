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
use advanced_testcase;
use block_site_stats;
use context_system;

/**
 * PHPUnit block_site_stats tests
 *
 * @package    block_site_stats
 * @category   test
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @coversDefaultClass \block_site_stats
 */
class site_stats_test extends advanced_testcase {
    public static function setUpBeforeClass(): void {
        require_once(__DIR__ . '/../../moodleblock.class.php');
        require_once(__DIR__ . '/../block_site_stats.php');
    }

    /**
     * Test the behaviour of can_block_be_added() method.
     *
     * @covers ::can_block_be_added
     */
    public function test_can_block_be_added_admin(): void {
        $this->resetAfterTest();

        // Test whether admin can add block on dashboard.
        $this->setAdminUser();

        $page = new \moodle_page();
        $page->set_context(context_system::instance());
        $page->set_pagelayout('mydashboard');

        $block = new block_site_stats();

        $this->assertTrue($block->can_block_be_added($page));


        // Test whether admin can add block on frontpage.
        $page->set_pagelayout('frontpage');

        $this->assertFalse($block->can_block_be_added($page));

    }
    /**
     * Test the behaviour of can_block_be_added() method.
     *
     * @covers ::can_block_be_added
     */
    public function test_can_block_be_added_user(): void {
        $this->resetAfterTest();

        // Test whether other users can add block on dashboard.
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);

        $page = new \moodle_page();
        $page->set_context(context_system::instance());
        $page->set_pagelayout('mydashboard');

        $block = new block_site_stats();

        $this->assertFalse($block->can_block_be_added($page));

        // Test whether other users can add block on frontpage.
        $page->set_pagelayout('frontpage');

        $this->assertFalse($block->can_block_be_added($page));
    }
    /**
     * Test the behaviour of can_block_be_added() method.
     *
     * @covers ::can_block_be_added
     */
    public function test_can_block_be_added_manager(): void {
        $this->resetAfterTest();

        // Test whether manager can add block on dashboard.
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->role_assign('manager', $user->id);
        $this->setUser($user);

        $page = new \moodle_page();
        $page->set_context(context_system::instance());
        $page->set_pagelayout('mydashboard');

        $block = new block_site_stats();

        $this->assertTrue($block->can_block_be_added($page));

        // Test whether manager can add block on frontpage.
        $page->set_pagelayout('frontpage');

        $this->assertFalse($block->can_block_be_added($page));
    }
}
