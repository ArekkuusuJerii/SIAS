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
                    'required' => true
                )
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Contraseña',
                'attr' => array(
                    'required' => true
                )
            ))
            ->add('role', ChoiceType::class, array(
                'label' => 'Rol',
                'choices' => array(
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN'
                ),
                'attr' => array(
                    'required' => true
                )
            ))
            ->add('persona', PersonaType::class);
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
