<div class="sorteos form">
<?php echo $form->create('Sorteo');?>
	<fieldset>
 		<legend><?php __('Edit Sorteo');?></legend>
	<?php
		echo $form->input('sorteo_id');
		echo $form->input('nom');
		echo $form->input('descripcio');
		echo $form->input('data_inici');
		echo $form->input('data_avis');
		echo $form->input('data_finalitzar');		
	?>
		<dl><?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estat'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $this->data['Sorteo']['Estat']; ?>
				&nbsp;
			</dd>
		</dl>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Sorteo.sorteo_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Sorteo.sorteo_id'))); ?></li>
		<li><?php echo $html->link(__('List Sorteos', true), array('action'=>'index'));?></li>
	</ul>
</div>
