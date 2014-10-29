<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('assets_homepage', new Route('/hello/{name}', array(
    '_controller' => 'AssetsBundle:Default:index',
)));

return $collection;
