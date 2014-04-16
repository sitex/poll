<?php

// Basic
CroogoRouter::connect('/', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'promoted'
));

CroogoRouter::connect('/promoted/*', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'promoted'
));

CroogoRouter::connect('/search/*', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'search'
));

// Content types
CroogoRouter::contentType('article');
CroogoRouter::contentType('news');
CroogoRouter::contentType('catalog');
CroogoRouter::contentType('topic');
CroogoRouter::contentType('shop');
CroogoRouter::contentType('event');
CroogoRouter::contentType('private');
if (Configure::read('Install.installed')) {
	CroogoRouter::routableContentTypes();
}

// Cataglog City
CroogoRouter::connect('/catalog/city/:slug', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'term',
	'type' => 'catalog'
));

// Page
CroogoRouter::connect('/about', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'view',
	'type' => 'page', 'slug' => 'about'
));
CroogoRouter::connect('/page/:slug', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'view',
	'type' => 'page'
));
