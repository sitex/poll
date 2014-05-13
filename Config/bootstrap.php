<?php


/**
 * Admin menu (navigation)
 */
CroogoNav::add('polls', array(
	'icon' => array('bar-chart', 'large'),
	'title' => __d('polls','Polls'),
	'weight' => 11,
	'url' => array(
		'admin' => true,
		'plugin' => 'polls',
		'controller' => 'polls',
		'action' => 'index',
	),
));
