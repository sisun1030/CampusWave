<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'name';
	var $actsAs = array('Acl' => array('type' => 'requester'));
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	 
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
}
?>