<?php

namespace Braunstetter\ValidFormEvent\Tests;

use Braunstetter\ValidFormEvent\DependencyInjection\ValidFormEventBundleExtension;
use Braunstetter\ValidFormEvent\Form\Extension\ValidFormEventTypeExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class BundleExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [new ValidFormEventBundleExtension()];
    }

    public function test_twig_extension_gets_loaded()
    {
        $this->load();
        $this->assertContainerBuilderHasService(ValidFormEventTypeExtension::class);
    }

}