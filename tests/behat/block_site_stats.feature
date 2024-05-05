@block @block_site_stats
Feature: Check if the site_stats block is added to the Moodle dashboard page
  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email | idnumber |
      | student1 | Student | 1 | student1@example.com | S1 |
  Scenario: Add the block to the dashboard page by admin
    Given I log in as "admin"
    And I turn editing mode on
    When I add the "Site Statistics" block
    Then "Site Statistics" "block" should exist

  Scenario:  Add the block to the dashboard page by student
    Given I log in as "student1"
    And I turn editing mode on
    Then the add block selector should not contain "Site Statistics" block