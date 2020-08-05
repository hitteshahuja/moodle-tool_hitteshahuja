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
 * Used to display the interface for the plugin.
 * @module     hitteshahuja
 * @package    admin/tool
 * @copyright  2020 Hittesh Ahuja <hittesh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/

import $ from 'jquery';
import Ajax from 'core/ajax';
import Notification from 'core/notification';
import Pending from 'core/pending';
import Templates from 'core/templates';
import {get_strings as getStrings} from 'core/str';

const init = () => {
    var deleteelement = $('.deletetool');
    const pendingPromise = new Pending('tool_hitteshahuja/index_page');
    deleteelement.on('click', function (e) {
        e.preventDefault();
        var dataId = $(this).attr("data-id");
        var courseId = $(this).attr("data-courseid");

        // Show a confirmation.
        getStrings([
            {
                key: 'confirmdeletetitle',
                component: 'tool_hitteshahuja'
            },
            {
                key: 'confirmdeletequestion',
                component: 'tool_hitteshahuja'
            },
            {
                key: 'yes',
                component: 'moodle'
            },
            {
                key: 'no',
                component: 'moodle'
            }
        ]).then((s) => {
            Notification.confirm(s[0], s[1], s[2], s[3], () => {
                // Delete entry.
                deleteEntry(dataId).then(
                    () => {
                        Ajax.call([{
                            methodname: 'tool_hitteshahuja_show_template',
                            args: {
                                courseid: courseId,
                            }
                        }])[0].then((data) => {
                            // Reload the template.
                            console.log(data);
                            Templates.render('tool_hitteshahuja/index_page',data.content).then(function(html) {
                                console.log(html);
                                $('toolhitteshahujatable').html(html);
                                return;
                            }.bind(this))
                                .fail(Notification.exception);
                        });

                    }).catch(Notification.exception);
            });
            return;
        }).catch(Notification.exception);
        // Once deleted , reload the template again.
        pendingPromise.resolve();

    });
};
const deleteEntry = async (id) => {
    // Delete the entry using WS.
    Ajax.call([{
        methodname: 'tool_hitteshahuja_delete_entry',
        args: {
            entryid: id,
        }
    }])[0].then(() => {
        // Replace the container element content with the result of the WS call.
        return;
    }).catch(Notification.exception);
};
export default {
    init: init,
};


