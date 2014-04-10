<h3><?php echo __('Polls');?></h3>
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav pull-right">
				<li><a href="<?php echo $this->Html->url('/admin/polls/polls/add/#/edit_poll/0');?>"><i class="icon-plus"></i> Add</a></li>
			</ul>
		</div>
	</div>
</div>
<table cellpadding="0" cellspacing="0"  class="table table-striped table-bordered table-condensed">
	<tr>
		<th style="width:280px;"><?php echo $this->Paginator->sort('id');?></th>
		<th><?php echo $this->Paginator->sort('question');?></th>
		<th><?php echo $this->Paginator->sort('description');?></th>
		<th class="actions" style="text-align:center;width:250px;"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($polls as $poll): ?>
	<tr>
		<td><?php echo h($poll['Poll']['id']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['question']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['description']); ?>&nbsp;</td>
		<td class="actions" style="text-align:center;">
			<?php echo $this->Html->link(__('View'), array('admin'=>false, 'action' => 'index', $poll['Poll']['id']), array('class'=>'btn btn-small')); ?>
			<?php echo $this->Html->link(__('Statistic'), array('action' => 'view', $poll['Poll']['id']), array('class'=>'btn btn-small')); ?>
			<a class="btn btn-small" href="<?php echo $this->Html->url('/admin/polls/polls/edit/'.$poll['Poll']['id'].'/#/edit_poll/'.$poll['Poll']['id']);?>"><?php echo __('Edit');?></a>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $poll['Poll']['id']), array('class'=>'btn btn-small') ); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>


<div class="pagination">
	<p><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></p>
	<ul>
		<?php
		echo $this->Paginator->prev('&larr; ' . __('previous'), array('tag' => 'li','escape'=>false), null, array('tag' => 'li', 'escape'=>false, 'class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => '','tag' => 'li', 'before'=>'', 'after'=>''));
		echo $this->Paginator->next(__('next') . ' &rarr;', array('tag' => 'li','escape'=>false), null, array('tag' => 'li', 'escape'=>false, 'class' => 'next disabled'));
		?>
	</ul>
</div>
