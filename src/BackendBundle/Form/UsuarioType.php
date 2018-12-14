<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EmailType::class, array(
                'label' => 'Correo',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control form-group'
                )
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Contraseña',
                'attr' => array(
                    'required' => true,
                    'class' => 'form-control form-group'
                )
            ))
            ->add('persona', PersonaType::class, array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-group'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_usuario';
    }


}
