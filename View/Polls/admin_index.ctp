<h3><?php echo __d('polls', 'Polls');?></h3>

<div class="row-fluid">
	<div class="span12 actions">
		<ul class="nav-buttons">
			<li><a href="/admin/polls/polls/add/#/edit_poll/0" method="get" class="btn btn-success">Добавить</a></li>
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table cellpadding="0" cellspacing="0"  class="table table-striped table-bordered table-condensed">
			<tr>
				<th style="width:280px;"><?php echo $this->Paginator->sort('id');?></th>
				<th><?php echo $this->Paginator->sort('question', __d('polls','Question'));?></th>
				<th><?php echo $this->Paginator->sort('description', __d('polls','Description'));?></th>
				<th class="actions" style="text-align:center;width:250px;"></th>
			</tr>
			<?php
			foreach ($polls as $poll): ?>
			<tr>
				<td><?php echo h($poll['Poll']['id']); ?>&nbsp;</td>
				<td><?php echo h($poll['Poll']['question']); ?>&nbsp;</td>
				<td><?php echo h($poll['Poll']['description']); ?>&nbsp;</td>
				<td class="actions" style="text-align:center;">
					<?php
						$actions = array();
						$item = $poll;
						$modelClass = 'Poll';

						$actions[] = $this->Croogo->adminRowAction('',
							array('action' => 'view', $item[$modelClass]['id']),
							array('icon' => 'bar-chart', 'tooltip' => __d('croogo', 'Statistic'))
						);
						$actions[] = $this->Croogo->adminRowAction('',
							'/admin/polls/polls/edit/'.$item[$modelClass]['id'].'/#/edit_poll/'.$item[$modelClass]['id'],
							array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item'))
						);
						$actions[] = $this->Croogo->adminRowActions($item[$modelClass]['id']);
						$actions[] = $this->Croogo->adminRowAction('',
							array(
								'action' => 'delete',
								$item[$modelClass]['id'],
							),
							array(
								'icon' => 'trash',
								'tooltip' => __d('croogo', 'Remove this item')
							),
							__d('croogo', 'Are you sure?'));

						print $this->Html->div('item-actions', implode(' ', $actions));
					?>


				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php if ($pagingBlock = $this->fetch('paging')): ?>
			<?php echo $pagingBlock; ?>
		<?php else: ?>
			<?php if (isset($this->Paginator) && isset($this->request['paging'])): ?>
				<div class="pagination">
					<p>
					<?php
					echo $this->Paginator->counter(array(
						'format' => __d('croogo', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
					));
					?>
					</p>
					<ul>
						<?php echo $this->Paginator->first('< ' . __d('croogo', 'first')); ?>
						<?php echo $this->Paginator->prev('< ' . __d('croogo', 'prev')); ?>
						<?php echo $this->Paginator->numbers(); ?>
						<?php echo $this->Paginator->next(__d('croogo', 'next') . ' >'); ?>
						<?php echo $this->Paginator->last(__d('croogo', 'last') . ' >'); ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
