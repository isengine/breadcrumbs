<?php

namespace is\Masters\Modules\Isengine\Breadcrumbs;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Components\Dom;
use is\Components\Router;
use is\Masters\View;

$view = View::getInstance();
$router = Router::getInstance();

$instance = $object -> get('instance');
$sets = &$object -> settings;

$position = null;
$count = null;

// template

$container = System::set($object -> eget('container'));
$separator = System::set($object -> eget('separator'));

if ($container) {
	$object -> eget('container') -> addCustom('itemscope', '');
	$object -> eget('container') -> addCustom('itemtype', 'http://schema.org/BreadcrumbList');
}

if ($separator) {
	$object -> eget('separator') -> addContent($sets['separator-symbol']);
}

$object -> eget('item') -> addCustom('itemprop', 'itemListElement');
$object -> eget('item') -> addCustom('itemscope', '');
$object -> eget('item') -> addCustom('itemtype', 'http://schema.org/ListItem');

$object -> eget('link') -> addCustom('itemprop', 'item');

// open

if ($container) {
	$object -> eget('container') -> open(true);
}

// home

if ($sets['index']) {
	
	$count++;
	$c = null;
	
	if ($sets['classes']['index']) {
		$c = $object -> eget('item') -> classes;
		$object -> eget('item') -> addClass($sets['classes']['index']);
	}
	
	$object -> eget('item') -> open(true);
	if (!$sets['index-active']) {
		$object -> eget('link') -> addTag('span');
	} else {
		$object -> eget('link') -> addLink('/');
	}
	$content = '<span>' . $view -> get('lang|menu:index') . '</span><meta itemprop="position" content="' . $count . '">';
	$object -> eget('link') -> addContent($content);
	
	$object -> eget('link') -> open(true);
	$object -> eget('link') -> content(true);
	if ($separator) {
		$object -> eget('separator') -> print();
	}
	$object -> eget('link') -> close(true);
	
	$object -> eget('item') -> close(true);
	
	if ($c) {
		$object -> eget('item') -> setClass($c);
	}
	
	unset($c);
	
}

// other

if (System::typeIterable($object -> route)) {
	$last = Objects::last($object -> route, 'value');
	$object -> route = Objects::unlast($object -> route);
}

if (System::typeIterable($object -> route)) {
	foreach ($object -> route as $item) {
		
		$count++;
		$position .= ($position ? ':' : null) . $item;
		$link = $router -> structure -> getDataByName($position)['link'];
		$lang = $view -> get('lang|menu')[$position ? $position : 'index'];
		$content = '<span>' . ($lang ? $lang : $item) . '</span><meta itemprop="position" content="' . $count . '">';
		
		$object -> eget('item') -> open(true);
		
		$object -> eget('link') -> addTag('a');
		$object -> eget('link') -> addLink($link ? $link : '#');
		$object -> eget('link') -> addContent($content);
		
		$object -> eget('link') -> open(true);
		$object -> eget('link') -> content(true);
		if ($separator) {
			$object -> eget('separator') -> print();
		}
		$object -> eget('link') -> close(true);
		
		$object -> eget('item') -> close(true);
		
	}
	unset($key, $item);
}

// last

if ($last && $sets['last-item']) {
	
	$count++;
	$position .= ($position ? ':' : null) . $last;
	$link = $router -> structure -> getDataByName($position)['link'];
	$lang = $view -> get('lang|menu')[$position ? $position : 'index'];
	$content = '<span>' . ($lang ? $lang : $last) . '</span><meta itemprop="position" content="' . $count . '">';
	
	if ($sets['classes']['last-item']) {
		$object -> eget('item') -> addClass($sets['classes']['last-item']);
	}
	
	$object -> eget('item') -> addAria('current', 'page');
	
	$object -> eget('item') -> open(true);
	
	if (!$sets['last-item-active']) {
		$object -> eget('link') -> addTag('span');
	} else {
		$object -> eget('link') -> addLink($link ? $link : '#');
	}
	
	$object -> eget('link') -> addContent($content);
	
	$object -> eget('link') -> open(true);
	$object -> eget('link') -> content(true);
	$object -> eget('link') -> close(true);
	
	$object -> eget('item') -> close(true);
	
}

// close

if ($container) {
	$object -> eget('container') -> close(true);
}

?>