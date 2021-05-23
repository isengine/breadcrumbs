<?php

namespace is\Masters\Modules\Isengine;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Components\Uri;

use is\Masters\Modules\Master;
use is\Masters\View;

class Breadcrumbs extends Master {
	
	public $route;
	
	public function launch() {
		
		$uri = Uri::getInstance();
		$this -> route = $uri -> get('route');
		
	}
	
}

?>