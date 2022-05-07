<?php

namespace Braunstetter\ValidFormEvent\Tests\Functional;

use Braunstetter\ValidFormEvent\Tests\Functional\app\src\Form\NestedForm;
use Braunstetter\ValidFormEvent\Tests\Functional\app\src\Form\SimpleForm;
use Braunstetter\ValidFormEvent\Tests\Functional\app\src\Provider\FormProvider;
use Braunstetter\ValidFormEvent\Tests\Functional\app\TestKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\AlreadySubmittedException;

class FunctionalTest extends TestCase
{
    private mixed $formFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kernel = new TestKernel([]);
        $this->kernel->boot();

        $this->formFactory = $this->kernel->getContainer()->get(FormProvider::class);
    }

    public function test_event_gets_fired_when_valid(): void
    {
        $form = $this->formFactory->get()->create(SimpleForm::class);

        $this->expectException(AlreadySubmittedException::class);
        $form->submit(['title' => 'holla', 'email' => 'example_email@gmail.com']);
    }

    public function test_event_gets_not_fired_when_invalid(): void
    {
        $form = $this->formFactory->get()->create(SimpleForm::class);

        $this->expectNotToPerformAssertions();
        $form->submit(['title' => 'holla', 'email' => 'example_email']);
    }

    public function test_event_gets_fired_when_nested_form_is_valid(): void
    {
        $form = $this->formFactory->get()->create(NestedForm::class);

        $this->expectException(AlreadySubmittedException::class);

        $form->submit([
            'title' => 'holla',
            'email' => 'example_email@gmail.com',
            'nested' => ['title' => 'that\'s a title']
        ]);
    }

    public function test_event_gets_not_fired_when_nested_form_is_invalid(): void
    {
        $form = $this->formFactory->get()->create(NestedForm::class);

        $this->expectNotToPerformAssertions();
        $form->submit(['title' => 'holla', 'email' => 'example_email@gmail.com',]);
    }
}