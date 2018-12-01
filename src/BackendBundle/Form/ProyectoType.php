<?php

namespace BackendBundle\Form;

use BackendBundle\Entity\Desarrollador;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProyectoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array(
                'label' => 'Nombre',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'required' => false,
                'empty_data' => 'Sin descripción',
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('fechaInicio', DateType::class, array(
                'label' => 'Fecha de Inicio',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('fechaFin', DateType::class, array(
                'label' => 'Fecha de Finalización',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('empresa', EntityType::class, array(
                'class' => 'BackendBundle\Entity\Empresa',
                'choice_label' => 'nombre',
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => array(
                    'class' => 'form-control form-group'
                )
            ))
            ->add('lider', EntityType::class, array(
                'class' => 'BackendBundle\Entity\Desarrollador',
                'choice_label'  => function (Desarrollador $desarrollador) {
                    return $desarrollador->getUsuario()->getPersona()->getNombre()
                        . ' ' . $desarrollador->getUsuario()->getPersona()->getApellidop()
                        . ' ' . $desarrollador->getUsuario()->getPersona()->getApellidom();
                },
                'expanded' => false,
                'multiple' => false,
                'required' => false,
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
            'data_class' => 'BackendBundle\Entity\Proyecto'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_proyecto';
    }


}
