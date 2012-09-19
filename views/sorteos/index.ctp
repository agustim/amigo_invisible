<div class="sorteos index">
<h2><?php __('Sorteos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('nom');?></th>
	<th><?php echo $paginator->sort('descripcio');?></th>
	<th><?php echo $paginator->sort('data_inici');?></th>
	<th><?php echo $paginator->sort('data_avis');?></th>
	<th><?php echo $paginator->sort('data_finalitzar');?></th>
	<th><?php echo $paginator->sort('Estat');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($sorteos as $sorteo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($sorteo['Sorteo']['nom'],array('controller'=>'amigos','action'=>'',$sorteo['Sorteo']['sorteo_id'])); ?>
		</td>
		<td>
			<?php echo $sorteo['Sorteo']['descripcio']; ?>
		</td>
		<td>
			<?php echo $sorteo['Sorteo']['data_inici']; ?>
		</td>
		<td>
			<?php echo $sorteo['Sorteo']['data_avis']; ?>
		</td>
		<td>
			<?php echo $sorteo['Sorteo']['data_finalitzar']; ?>
		</td>
		<td>
			<?php echo $sorteo['Sorteo']['Estat']; ?>
		</td>
		<td class="actions">
		<?php if ($sorteo['Sorteo']['Estat'] == 'no sortejat') {
				echo $html->link(__('Sorteo', true), array('action'=>'todo', $sorteo['Sorteo']['sorteo_id']));
				echo $html->link(__('Edit', true), array('action'=>'edit', $sorteo['Sorteo']['sorteo_id']));
				echo $html->link(__('Delete', true), array('action'=>'delete', $sorteo['Sorteo']['sorteo_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sorteo['Sorteo']['nom']));
			}
			echo $html->link(__('View', true), array('action'=>'view', $sorteo['Sorteo']['sorteo_id'])); 
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
			<li><?php echo $html->link(__('New Sorteo', true), array('action'=>'add')); ?></li>
		</ul>
	</div>
