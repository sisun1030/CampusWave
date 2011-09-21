<?php

class User extends AppModel {
    var $name = 'User';
	var $belongsTo = array('Group');
	var $actsAs = array('Acl' => array('type' => 'requester'));
	 
	function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
		$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
		return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}
	
	function bindNode($user) {
		return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
    }

	function index() {
		$this->set('users', $this->User->find('all'));
	}
}

?>