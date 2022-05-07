<?php

namespace Braunstetter\ValidFormEvent\Form\Event;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class ValidFormEvent extends FormEvent
{
    const NAME = 'valid';

    private ?FormInterface $currentForm;

    public function __construct(FormInterface $form, mixed $data, ?FormInterface $currentForm = null)
    {
        parent::__construct($form, $data);
        $this->currentForm = $currentForm;
    }

    /**
     * @return FormInterface|null
     */
    public function getCurrentForm(): ?FormInterface
    {
        return $this->currentForm;
    }

}