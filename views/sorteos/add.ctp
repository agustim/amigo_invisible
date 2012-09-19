<div class="sorteos form">
<?php echo $form->create('Sorteo');?>
	<fieldset>
 		<legend><?php __('Add Sorteo');?></legend>
	<?php
		echo $form->input('nom');
		echo $form->input('descripcio');
		echo $form->input('data_inici');
		echo $form->input('data_avis');
		echo $form->input('data_finalitzar');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Sorteos', true), array('action'=>'index'));?></li>
	</ul>
</div>
