<?php

namespace Braunstetter\ValidFormEvent\Form\Extension;

use Braunstetter\ValidFormEvent\Form\Event\ValidFormEvent;
use Braunstetter\ValidFormEvent\Form\EventSubscriber\PropagateValidFormEventSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ValidFormEventTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
            $form = $event->getForm();

            if ($form->isValid() && $form->isRoot()) {
                $eventDispatcher = $event->getForm()->getConfig()->getEventDispatcher();
                $eventDispatcher->dispatch(new ValidFormEvent($event->getForm(), $event->getData()), ValidFormEvent::NAME);
            }
        });

        $builder->addEventSubscriber(new PropagateValidFormEventSubscriber());

    }

    /**
     * @inheritDoc
     */
    public
    static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}