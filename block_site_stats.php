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
 * Contains the class for the Site Statistics block.
 *
 * @package    block_site_stats
 * @copyright  2024 Santosh Nagargoje <santosh.nag2217@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_site_stats extends block_base {
    /**
     * Sets the block title
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_site_stats');
    }
    /**
     * Allow/Deny multiple block instances
     */
    public function instance_allow_multiple() {
        return false;
    }
    /**
     * Defines block applicable formats
     */
    public function applicable_formats() {
        return ['my' => true];
    }
    /**
     * Get the blocks visible content
     */
    public function get_content() {
        if (!has_capability('block/site_stats:view', context_system::instance())) {
            return '';
        }
        $renderable = new \block_site_stats\output\main();
        $renderer = $this->page->get_renderer('block_site_stats');
        $this->content = new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';
        return $this->content;
    }
    /**
     * This block shouldn't be added to dashboard page if the capability is disabled.
     *
     * @param moodle_page $page
     * @return bool
     */
    public function can_block_be_added(moodle_page $page): bool {
        if ($page->pagelayout == 'mydashboard') {
            return has_capability('block/site_stats:myaddinstance', context_system::instance());
        }
        return false;
    }
}
