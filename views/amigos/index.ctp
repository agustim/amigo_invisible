<div class="amigos index">
<h2><?php __('Amigos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('nom');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<?php
	 if($userObject['User']['group_id'] == 'admin') {
		echo '		<th>'.$paginator->sort('public_key').'</th>';
		echo '		<th>'.$paginator->sort('private_key').'</th>';
		echo '		<th>'.$paginator->sort('tu_amigo_id').'</th>';
	  } 
	?>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($amigos as $amigo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			echo $html->link(__($amigo['Amigo']['nom'], true), array('controller'=>'paginas','action'=>'view', $amigo['Amigo']['amigo_id'],$amigo['Amigo']['public_key']));
			 ?>(<?php 
			echo $html->link(__('Edit', true), array('controller'=>'paginas','action'=>'viewPrivate', $amigo['Amigo']['amigo_id'],$amigo['Amigo']['private_key']));
			 ?>)
		</td>
		<td>
			<?php echo $amigo['Amigo']['email']; ?>
		</td>
<?php
	if($userObject['User']['group_id'] == 'admin') {
		echo '		<td>';
		echo $amigo['Amigo']['public_key'];
		echo '		</td>';
		echo '		<td>';
		echo $amigo['Amigo']['private_key'];
		echo '		</td>';
		echo '		<td>';
		echo $amigo['TuAmigo']['nom'];
		echo '		</td>';
	}
?>
		<td class="actions">
<?php if ($amigo['Sorteo']['Estat'] == 'sortejat') {
		 echo $html->link(__('Send Key', true), array('action'=>'sendKey', $amigo['Amigo']['amigo_id'])); 
		}
	  if ($amigo['Sorteo']['Estat'] == 'no sortejat') {
		 echo $html->link(__('Edit', true), array('action'=>'edit', $amigo['Amigo']['amigo_id'])); 
		 echo $html->link(__('Restriccions', true), array('controller'=> 'restricciones', 'action'=>'amigo', $amigo['Amigo']['amigo_id']));
	     echo $html->link(__('Delete', true), array('action'=>'delete', $amigo['Amigo']['amigo_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $amigo['Amigo']['nom']));
		}
?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Amigo', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Sorteos', true), array('controller'=> 'sorteos', 'action'=>'index')); ?> </li>
	</ul>
</div>
