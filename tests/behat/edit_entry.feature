@tool @tool_hitteshahuja
Feature: Edit an existing tool entry
  In order to see a list of entries for a given course
  As a user who has edit capabilities
  I need to add a new tool entry

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname        | shortname   | category |
      | NEW Fire Safety | Fire Safety | 0        |
    And the following "course enrolments" exist:
      | user     | course      | role           |
      | teacher1 | Fire Safety | editingteacher |

  Scenario: Edit an existing entry
    When I log in as "teacher1"
    And I am on "NEW Fire Safety" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    And I click on "Add" "link"
    And I set the field "Name" to "BehatCourseEntry"
    And I click on "Add" "button"
    And I click on "Edit" "link" in the "BehatCourseEntry" "table_row"
    And I set the field "Name" to "BehatCourseEntry2"
    #And I check "Completed"
    And I click on "Add" "button"
    Then I should see "BehatCourseEntry2" in the "BehatCourseEntry2" "table_row"
