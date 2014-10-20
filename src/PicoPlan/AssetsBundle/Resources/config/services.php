<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'pico_plan_assets.example',
    new Definition(
        'PicoPlan\AssetsBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/