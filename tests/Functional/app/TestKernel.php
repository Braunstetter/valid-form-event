<?php

namespace Braunstetter\ValidFormEvent\Tests\Functional\app;

use Braunstetter\ValidFormEvent\ValidFormEventBundle;
use Exception;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\VarDumper\VarDumper;

final class TestKernel extends Kernel
{
    /**
     * @param string[] $configs
     */
    public function __construct(
        private array $configs = []
    )
    {
        parent::__construct('test', true);
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new ValidFormEventBundle(),
        ];
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/bs_valid_form_event_test';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/bs_valid_form_event_test_log';
    }

    /**
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/Resources/config/config.yaml');
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
}
