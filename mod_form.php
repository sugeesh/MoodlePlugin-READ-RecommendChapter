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
 * The main recommendchapter configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_recommendchapter
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 *
 * @package    mod_recommendchapter
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_recommendchapter_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;
        global $DB;
        global $COURSE;

        $recbooks = $DB->get_records('recommendbook', array('course'=>$COURSE->id), $sort='', $fields='*', $limitfrom=0, $limitnum=0);

        $booklist=array();

        foreach ($recbooks as $recbook) {
            $booklist += array($recbook->id => $recbook->name);
        }


        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('select', 'recommend_book_id', 'Select Recommend Book', $booklist);

//        $mform->addElement('hidden', 'recommend_book_id', $idlist);

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('recommendchaptername', 'recommendchapter'), array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'recommendchaptername', 'recommendchapter');


        $mform->addElement('text', 'start_page', 'starting page',array('size'=>'20'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('start_page', PARAM_TEXT);
        } else {
            $mform->setType('start_page', PARAM_CLEANHTML);
        }

        $mform->addElement('text', 'end_page', 'ending page',array('size'=>'20'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('end_page', PARAM_TEXT);
        } else {
            $mform->setType('end_page', PARAM_CLEANHTML);
        }





        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();

        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
    }
}
