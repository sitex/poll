<ul class="breadcrumb">
    <li>
		<?php echo $this->Html->link(__('Manage Poll'), array('action'=>'index'));?>
		<span class="divider">/</span>
	</li>
    <li class="active"><?php echo __('New Poll'); ?></li>
</ul>
<div class="polls form" ng-app="poll">
<?php echo $this->Form->create('Poll', array('class'=>'form-horizontal', 'type'=>'file', 'name'=>'myForm'));?>
	<fieldset>
		<legend><?php echo __('New Poll'); ?></legend>
	<?php
		echo $this->Form->input('question', array('div'=>'control-group','placeholder'=>'',
					'before'=>'<label class="control-label">'.__('Question').'</label><div class="controls">',
					'after'=>$this->Form->error('question', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
					'error' => array('attributes' => array('style' => 'display:none')),
					'label'=>false, 'class'=>'input-xxlarge'));
		echo $this->Form->input('description', array('div'=>'control-group','placeholder'=>'',
					'before'=>'<label class="control-label">'.__('Description').'</label><div class="controls">',
					'after'=>$this->Form->error('description', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
					'error' => array('attributes' => array('style' => 'display:none')),
					'label'=>false, 'class'=>'input-xxlarge'));
	?>
		<div ng-view></div>
	</fieldset>
    <div class="form-actions">
        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary', 'div'=>false, 'onclick'=>'document.myForm.setAttribute(\'novalidate\', \'true\');document.myForm.submit();'));?>
    </div>
<?php $this->Form->end();?>
</div>
<?php $this->append('script');?>
<script>
var baseURL = "<?php echo Router::url('/', true).'polls/';?>";
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<?php
echo $this->Html->script(array('/polls/js/angular.min.js', '/polls/js/angular-ui.min'));
echo $this->Html->script(array( '/polls/js/poll/app', '/polls/js/poll/controller'));
?>
<?php $this->end();?>