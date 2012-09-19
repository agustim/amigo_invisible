<?php
class Restriccione extends AppModel {

	var $name = 'Restriccione';
	var $useTable = 'restricciones';
	var $primaryKey = 'restriccion_id';
	var $validate = array(
		'restriccion_id' => array('numeric'),
		'amigo_id' => array('numeric'),
		'user_id'=> array('numeric'),
		'amigo_invisible_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Amigo' => array('className' => 'Amigo',
								'foreignKey' => 'amigo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'AmigoInvisible' => array('className' => 'Amigo',
								'foreignKey' => 'amigo_invisible_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>