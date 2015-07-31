<?php

namespace AppBundle\Form;

use AppBundle\Entity\Problem;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SwitchProblemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $contextProject = $options['contextProject'];

        $builder
            ->add('value', 'entity', [
                'class' => Problem::class,
                'data_class' => null,
                'query_builder' => function (EntityRepository $entityRepository) use ($contextProject) {
                    $qb = $entityRepository->createQueryBuilder('p');

                    return $qb
                        ->where($qb->expr()->eq('p.project', ':contextProject'))
                        ->setParameter('contextProject', $contextProject)
                    ;
                },
                'constraints' => [new NotBlank()],
                'label' => 'Current Task:',
                'choice_label' => 'value',
            ])
            ->add('submit', 'submit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'contextProject' => null,
            ])
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
