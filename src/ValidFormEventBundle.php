<?php

namespace Braunstetter\ValidFormEvent;

use Braunstetter\ValidFormEvent\DependencyInjection\ValidFormEventBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ValidFormEventBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ValidFormEventBundleExtension();
    }

}