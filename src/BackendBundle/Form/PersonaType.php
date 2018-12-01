<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control form-group'
                )
            ))
            ->add('apellidop', TextType::class, array(
                'label' => 'Apellido Paterno',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control form-group'
                )
            ))
            ->add('apellidom', TextType::class, array(
                'label' => 'Apellido Materno',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control form-group'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_persona';
    }


}
