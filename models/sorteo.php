<?php
class Sorteo extends AppModel {

	var $name = 'Sorteo';
	var $useTable = 'sorteos';
	var $primaryKey = 'sorteo_id';
	var $validate = array(
		'sorteo_id' => array('numeric'),
		'user_id' => array('numeric'),
		'data_inici' => array('date'),
		'data_avis' => array('date'),
		'data_finalitzar' => array('date')
	);

	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	var $hasMany = array(
			'Amigo' => array('className' => 'Amigo',
								'foreignKey' => 'sorteo_id',
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
	function getEstatList(){
		return (array('no sortejat'=>'no sortejat','sortejat'=>'sortejat','finalitzat'=>'finalitzat'));
	}
}
?>