<?php

namespace Braunstetter\ValidFormEvent\Tests\Functional\app\src\Form;

use Braunstetter\ValidFormEvent\Form\Event\ValidFormEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\VarDumper\VarDumper;

class NestedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotNull(),
                    new Email()
                ]
            ])
            ->add('nested', ChildForm::class)
            ->add('submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }


}