<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActividadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'attr' => array(
                    'required' => true
                )
            ))
            ->add('fechaInicio', DateType::class, array(
                'label' => 'Fecha de Inicio',
                'attr' => array(
                    'required' => true
                )
            ))
            ->add('fechaFin', DateType::class, array(
                'label' => 'Fecha de Finalización',
                'attr' => array(
                    'required' => true
                )
            ))
            ->add('participante')
            ->add('proyecto');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Actividad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_actividad';
    }


}
