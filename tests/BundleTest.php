<?php

namespace Braunstetter\ValidFormEvent\Tests;

use Nyholm\BundleTest\AppKernel;
use Braunstetter\ValidFormEvent\DependencyInjection\ValidFormEventBundleExtension;
use Braunstetter\ValidFormEvent\ValidFormEventBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var AppKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addBundle(ValidFormEventBundle::class);

        return $kernel;
    }

    public function testInitBundle(): void
    {
        self::bootKernel();
        $bundle = self::$kernel->getBundle('ValidFormEventBundle');
        $this->assertInstanceOf(ValidFormEventBundle::class, $bundle);
        $this->assertInstanceOf(ValidFormEventBundleExtension::class, $bundle->getContainerExtension());
    }

}