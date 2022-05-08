<?php

declare(strict_types=1);

use Braunstetter\ValidFormEvent\Form\Extension\ValidFormEventTypeExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $containerConfigurator): void {

    $services = $containerConfigurator->services();

    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('Braunstetter\\ValidFormEvent\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/ValidFormEventBundle.php',
            __DIR__ . '/../src/Form/Event/ValidFormEvent.php',
        ]);

    $services->set(ValidFormEventTypeExtension::class)
        ->tag('form.type_extension');
};
