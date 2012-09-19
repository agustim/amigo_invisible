<div class="users form">
<?php echo $form->create('User', array('action' => 'register'));?>
	<fieldset>
 		<legend><?php __('Register User');?></legend>
	<?php
		echo $form->input('username', array(
			'error' => array(
			'unic' => 'Ja existeix un altre Usuari amb aquest nom.',
	        	'required' => 'Please specify a valid title',
	        	'length' => 'El nom ha de tenir entre 5 i 20 caracters.'
		 		)
			)
		);
		echo $form->input('email', array(
			'error' => array(
				'tipus' => 'Has d\'escriure una adreça de correu electronic'
				)
			)
		);
		echo $form->input('first_password',array('type'=>'password','label'=>'Password'));
		echo $form->input('confirm_password',array('type'=>'password','label'=>'Confirm Password'));
	?>
	</fieldset>
<?php echo $form->end('Registrame');?>
</div>
<div class="actions">
</div>
