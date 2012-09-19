<div class="users form">
<?php echo $form->create('User', array('admin' => true, 'action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('user_id');
		echo $form->input('username');
		echo $form->input('email');
		echo $form->input('first_password',array('type'=>'password','label'=>'Password'));
		echo $form->input('confirm_password',array('type'=>'password','label'=>'Confirm Password'));
		echo $form->input('active', array('options' => array('1'=>'actiu','0'=>'inactiu')));
		echo $form->input('group_id', array('options' => array('admin'=>'Administrador','user'=>'Usuari')));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('User.user_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.user_id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
	</ul>
</div>
