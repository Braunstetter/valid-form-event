<?php

namespace Braunstetter\ValidFormEvent\Form\EventSubscriber;

use Braunstetter\ValidFormEvent\Form\Event\ValidFormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

class PropagateValidFormEventSubscriber implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            ValidFormEvent::NAME => 'onFormValid',
        );
    }

    public function onFormValid(ValidFormEvent $event)
    {
        if ($event->getCurrentForm() === null) {
            $this->dispatchOnChildren($event->getForm(), $event);
        }
    }

    private function dispatchOnChildren(FormInterface $form, FormEvent $rootEvent)
    {
        foreach ($form as $child) {

            if ($child->getConfig() instanceof ButtonBuilder) {
                continue;
            }

            /** @var $child FormInterface */
            $eventDispatcher = $child->getConfig()->getEventDispatcher();
            $eventDispatcher->dispatch(new ValidFormEvent($rootEvent->getForm(), $rootEvent->getData(), $child), ValidFormEvent::NAME);

            $this->dispatchOnChildren($child, $rootEvent);
        }
    }
}