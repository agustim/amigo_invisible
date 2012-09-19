<div class="sorteos view">
<h2><?php  __('Sorteo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sorteo Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['sorteo_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nom'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['nom']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descripcio'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['descripcio']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data Inici'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['data_inici']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data Avis'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['data_avis']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data Finalitzar'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['data_finalitzar']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Estat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sorteo['Sorteo']['Estat']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
<?php if ($sorteo['Sorteo']['Estat'] == 'no sortejat') { ?>
		<li><?php echo $html->link(__('Edit Sorteo', true), array('action'=>'edit', $sorteo['Sorteo']['sorteo_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Sorteo', true), array('action'=>'delete', $sorteo['Sorteo']['sorteo_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sorteo['Sorteo']['nom'])); ?> </li>
<?php } ?>
		<li><?php echo $html->link(__('List Sorteos', true), array('action'=>'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Amigos');?></h3>
	<?php if (!empty($sorteo['Amigo'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Nom'); ?></th>
		<th><?php __('Email'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($sorteo['Amigo'] as $amigo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $amigo['nom'];?></td>
			<td><?php echo $amigo['email'];?></td>
			<td class="actions">
			<?php if ($sorteo['Sorteo']['Estat'] == 'sortejat') {
					 echo $html->link(__('Send Key', true), array('action'=>'sendKey', $amigo['amigo_id'])); 
					}
				  if ($sorteo['Sorteo']['Estat'] == 'no sortejat') {
					 echo $html->link(__('Edit', true), array('action'=>'edit', $amigo['amigo_id'])); 
					 echo $html->link(__('Restriccions', true), array('controller'=> 'restricciones', 'action'=>'amigo', $amigo['amigo_id']));
				     echo $html->link(__('Delete', true), array('action'=>'delete', $amigo['amigo_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $amigo['nom']));
					}
			?>			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Amigo', true), array('controller'=> 'amigos', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
