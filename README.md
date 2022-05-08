# Valid FormEvent Bundle

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Braunstetter/valid-form-event/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/Braunstetter/valid-form-event/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/Braunstetter/valid-form-event/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/Braunstetter/valid-form-event/?branch=main)
[![Build Status](https://app.travis-ci.com/Braunstetter/valid-form-event.svg?branch=main)](https://app.travis-ci.com/Braunstetter/valid-form-event)
[![Total Downloads](http://poser.pugx.org/braunstetter/valid-form-event/downloads)](https://packagist.org/packages/braunstetter/valid-form-event)
[![License](http://poser.pugx.org/braunstetter/valid-form-event/license)](https://packagist.org/packages/braunstetter/valid-form-event)

The Symfony documentation recommends keeping logic out of forms and instead doing everything inside a controller.
That's probably good advice most of the time, but exceptions prove the rule.

Because when you have flexible forms, like a page builder with flexible sections, it's very helpful if the individual
sections could do things once the entire form is valid. (Like uploading an image)

This bundle provides exactly this functionality.

## Installation

`composer require braunstetter/valid-form-event`

## Usage

```php 
<?php


namespace App\Form\Paragraph;

use Braunstetter\MediaBundle\Manager\FilesystemManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Braunstetter\ValidFormEvent\Form\Event\ValidFormEvent;
use App\Entity\MyCustomPageBlock;

class MyPageBlockType extends AbstractType
{

    private FilesystemManager $filesystemManager;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager->setFolder('/uploads/images/page_blocks');
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'constraints' => [
                    new Image(['maxSize' => '5M'])
                ]
            ])
            ->add('description')

            // Here is the important part.
            // Inside the 'valid' event you can do whatever you want to.
            ->addEventListener(ValidFormEvent::NAME, function (ValidFormEvent $event) {
                $form = $event->getCurrentForm() ?? $event->getForm();

                if ($image = $form->get('image')->getData()) {
                    $this->filesystemManager->upload($image);
                }
            });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MyCustomPageBlock::class,
        ]);
    }
}

```

That's pretty self-explanatory.

Everything works exactly the same as with the other Symfony FormEvents.
It should also be noted that the `$event->getCurrentForm()` method is also available. This gives you the current form you are in - but only if that form is a child of a parent form. The parent form can easily be reached with `$event->getForm()`.

> This event works with all forms, even if they are nested.



