<?php
class User extends AppModel {

	var $name = 'User';
	var $useTable = 'users';
	var $primaryKey = 'user_id';
	var $validate = array(
		'user_id' => array('numeric'),
		'username' => array(
			'unic' => array(
				'rule' => 'validarUnico'
			),
			'length' => array(
				'rule' => array('between', 5, 20)
			),
			'required' => VALID_NOT_EMPTY	
		),
		'email' => array('tipus' => 'email'),
		'password' => array(
			'alphaNumeric'
		)
	);

	var $hasMany = array(
			'Sorteo' => array('className' => 'Sorteo',
								'foreignKey' => 'user_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);
	function validarUnico($value){
		if(!isset($this->data[$this->name]['user_id'])) {
			$buscar_nombre = $this->findAllByUsername ($value);
			if (!empty($buscar_nombre)) {
		       return false;
		   	}
		}
		return true;
	}
	function validateLength($values, $params = array()) {
		$params = am(array(
		    'min' => null,
		    'max' => null,
		), $params);

		$valid = true;
		foreach($values as $value) {
			$valid = $valid && (!empty($params['min']) && !empty($params['max']) 
					 && strlen($value) >= $params['min'] && strlen($value) <= $params['max']);
		}
		return $valid;
	}
}
?>