<?php
class Amigo extends AppModel {

	var $name = 'Amigo';
	var $useTable = 'amigos';
	var $primaryKey = 'amigo_id';
	var $validate = array(
		'amigo_id' => array('numeric'),
		'email' => array('email'),
		'public_key' => array('alphaNumeric'),
		'private_key' => array('alphaNumeric'),
		'sorteo_id' => array('numeric'),
		'user_id' => array('numeric')
	);

	var $belongsTo = array(
			'Sorteo' => array('className' => 'Sorteo',
								'foreignKey' => 'sorteo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'TuAmigo' => array('className' => 'Amigo',
								'foreignKey' => 'tu_amigo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasMany = array(
			'Pagina' => array('className' => 'Pagina',
								'foreignKey' => 'amigo_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Restriccione' => array('className' => 'Restriccione',
								'foreignKey' => 'amigo_id',
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

}
?>