<?php

namespace AppBundle\Form;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SwitchProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'entity', [
                'class' => Project::class,
                'data_class' => null,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('p');
                },
                'label' => 'Current Project:',
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
        return 'app_switch_project_type';
    }
}
