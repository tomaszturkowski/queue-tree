<?php

namespace AppBundle\Form;

use AppBundle\Entity\Problem;
use AppBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SwitchProblemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'entity', [
                'class' => Problem::class,
                'constraints' => [new NotBlank()],
                'label' => 'Switch To Problem:',
                'choice_label' => 'value',
            ])
            ->add('submit', 'submit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_switch_problem_type';
    }
}
