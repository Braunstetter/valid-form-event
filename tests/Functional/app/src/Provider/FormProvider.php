<?php

namespace Braunstetter\ValidFormEvent\Tests\Functional\app\src\Provider;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;

class FormProvider
{
    private FormFactory $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function get(): FormFactory
    {
        return $this->factory;
    }
}