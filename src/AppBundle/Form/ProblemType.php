<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProblemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', [
                'choices' => [
                    'part' => 'Part',
                    'idea' => 'Idea',
                    'note' => 'Note',
                ],
                'constraints' => [new NotBlank()],
            ])
            ->add('value', 'text', [
                'constraints' => [new NotBlank()],
            ])
            ->add('create', 'submit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_problem_type';
    }
}
