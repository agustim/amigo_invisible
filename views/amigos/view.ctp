<div class="amigos view">
<h2><?php  __('Amigo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amigo Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['amigo_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nom'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['nom']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Public Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['public_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Private Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['private_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sorteo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($amigo['Sorteo']['sorteo_id'], array('controller'=> 'sorteos', 'action'=>'view', $amigo['Sorteo']['sorteo_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $amigo['Amigo']['user_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tu Amigo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($amigo['TuAmigo']['amigo_id'], array('controller'=> 'amigos', 'action'=>'view', $amigo['TuAmigo']['amigo_id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Amigo', true), array('action'=>'edit', $amigo['Amigo']['amigo_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Amigo', true), array('action'=>'delete', $amigo['Amigo']['amigo_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $amigo['Amigo']['amigo_id'])); ?> </li>
		<li><?php echo $html->link(__('List Amigos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Amigo', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Sorteos', true), array('controller'=> 'sorteos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sorteo', true), array('controller'=> 'sorteos', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Amigos', true), array('controller'=> 'amigos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tu Amigo', true), array('controller'=> 'amigos', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Paginas', true), array('controller'=> 'paginas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Pagina', true), array('controller'=> 'paginas', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Restricciones', true), array('controller'=> 'restricciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Restriccione', true), array('controller'=> 'restricciones', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Paginas');?></h3>
	<?php if (!empty($amigo['Pagina'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Pagina Id'); ?></th>
		<th><?php __('Amigo Id'); ?></th>
		<th><?php __('Version'); ?></th>
		<th><?php __('Contenido'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($amigo['Pagina'] as $pagina):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pagina['pagina_id'];?></td>
			<td><?php echo $pagina['amigo_id'];?></td>
			<td><?php echo $pagina['version'];?></td>
			<td><?php echo $pagina['contenido'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'paginas', 'action'=>'view', $pagina['pagina_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'paginas', 'action'=>'edit', $pagina['pagina_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'paginas', 'action'=>'delete', $pagina['pagina_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pagina['pagina_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Pagina', true), array('controller'=> 'paginas', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Restricciones');?></h3>
	<?php if (!empty($amigo['Restriccione'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Restriccion Id'); ?></th>
		<th><?php __('Amigo Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Amigo Invisible Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($amigo['Restriccione'] as $restriccione):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $restriccione['restriccion_id'];?></td>
			<td><?php echo $restriccione['amigo_id'];?></td>
			<td><?php echo $restriccione['user_id'];?></td>
			<td><?php echo $restriccione['amigo_invisible_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'restricciones', 'action'=>'view', $restriccione['restriccion_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'restricciones', 'action'=>'edit', $restriccione['restriccion_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'restricciones', 'action'=>'delete', $restriccione['restriccion_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $restriccione['restriccion_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Restriccione', true), array('controller'=> 'restricciones', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
