<?php

namespace BackendBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DesarrolladorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', UsuarioType::class, array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-group'
                )
            ))
            ->add('puesto', EntityType::class, array(
                'class' => 'BackendBundle\Entity\Puesto',
                'choice_label' => 'titulo',
                'expanded' => false,
                'multiple' => false,
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Submit',
                'attr' => array(
                    'class' => 'btn btn-primary form-group'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Desarrollador'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_desarrollador';
    }


}
