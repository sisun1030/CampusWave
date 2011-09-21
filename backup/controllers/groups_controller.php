<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $scaffold;
	function index() {
		$this->set('groups', $this->Group->find('all'));
	}
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('*'));
    }
	function add(){}

}
?>