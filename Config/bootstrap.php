<?php


/**
 * Admin menu (navigation)
 */
CroogoNav::add('content.children.example', array(
	'title' => __d('polls','Polls'),
	'url' => array(
		'admin' => true,
		'plugin' => 'polls',
		'controller' => 'polls',
		'action' => 'index',
	),
));
