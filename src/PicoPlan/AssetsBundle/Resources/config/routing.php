<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('pico_plan_assets_homepage', new Route('/hello/{name}', array(
    '_controller' => 'PicoPlanAssetsBundle:Default:index',
)));

return $collection;
