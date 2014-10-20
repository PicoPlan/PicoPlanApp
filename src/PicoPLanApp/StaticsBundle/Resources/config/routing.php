<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('pico_p_lan_app_statics_homepage', new Route('/hello/{name}', array(
    '_controller' => 'PicoPLanAppStaticsBundle:Default:index',
)));

return $collection;
