<?php

namespace is\Masters\Modules\Isengine;

use is\Helpers\System;
use is\Helpers\Objects;
use is\Helpers\Strings;

use is\Components\Uri;
use is\Components\Router;

use is\Masters\Modules\Master;
use is\Masters\View;

class Breadcrumbs extends Master
{
    public $route;

    public function launch()
    {
        $uri = Uri::getInstance();
        $this->route = $uri->get('route');

        $router = Router::getInstance();

        //$this->content = $router->content;

        $content = $router->content;
        //if ($content['parents']) {
        //    $content['parents'] = Objects::unfirst($content['parents']);
        //    if ($content['parents']) {
        //        $this->route = Objects::add($this->route, $content['parents']);
        //    }
        //}
        if ($content['name']) {
            $this->route = Objects::add($this->route, [ $content['name'] ]);
        }

        //System::debug($content);
        //System::debug($this->route);
    }
}
