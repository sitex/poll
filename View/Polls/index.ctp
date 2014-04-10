<ul class="breadcrumb">
    <li>
        <?php echo $this->Html->link(__('Manage Poll'), array('admin'=>true, 'plugin'=>'polls','action'=>'index'));?>
        <span class="divider">/</span>
    </li>
    <li class="active"><?php echo __('View'); ?></li>
</ul>


<div class="polls form" id="poll-container" ng-app="poll">
    <poll poll-id="'<?php echo $id;?>'"></poll>
</div>
<?php $this->append('script');?>
<script>
var baseURL = "<?php echo Router::url('/', true).'polls/';?>";
</script>
<?php
echo $this->Html->script(array('/polls/js/angular.min.js', '/polls/js/angular-ui.min'));
echo $this->Html->script(array( '/polls/js/poll/app', '/polls/js/poll/controller'));
?>
<?php $this->end();?>