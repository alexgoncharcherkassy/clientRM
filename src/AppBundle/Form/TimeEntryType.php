<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class TimeEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $projectId = $options['projectId'];
        $issueId = $options['issueId'];
        if($issueId)
            $builder
                ->add('issueId', TextType::class,[
                    'label' => 'Issue id',
                    'required' => true,
                    'disabled' => true,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'data' => $issueId
                ]);
        $builder
            ->add('projectId', HiddenType::class, [
                'data' => $projectId,
            ])
            ->add('hours', TextType::class,[
                'label' => 'Hours',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('comments', TextareaType::class,[
                'label' => 'Comment',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\TimeEntry',
            'projectId' => null,
            'issueId'   => null,
        ]);
    }
    public function getBlockPrefix()
    {
        return 'time_entry';
    }
}