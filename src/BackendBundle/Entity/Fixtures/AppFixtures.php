<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/25/2018
 * Time: 2:39 PM
 */

namespace BackendBundle\Entity\Fixtures;


use BackendBundle\Entity\Persona;
use BackendBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AppFixtures implements FixtureInterface, EncoderAwareInterface
{
    /**
     *
     * @var ContainerAwareInterface
     */
    private $encoder_factory;

    /**
     * Set the ContainerAwareInteface method to load any services for data fixture classes
     *
     * {@inheritDoc}
     * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
     */
    public function __construct(EncoderFactoryInterface $encoder_factory)
    {
        $this->encoder_factory = $encoder_factory;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $persona = new Persona();
        $persona->setNombre("Admin");
        $persona->setApellidop("Mr");
        $persona->setApellidom("Dick");
        $usuario = new Usuario();
        $usuario->setUser("admin@g.c");
        $usuario->setPassword("admin");

        $encoder = $this->encoder_factory->getEncoder($usuario);
        $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());

        $usuario->setPassword($password);
        $usuario->setPersona($persona);
        $usuario->setRol("ROLE_ADMIN");
        $manager->persist($usuario);
        $manager->flush();
    }

    /**
     * Gets the name of the encoder used to encode the password.
     *
     * If the method returns null, the standard way to retrieve the encoder
     * will be used instead.
     *
     * @return string
     */
    public function getEncoderName()
    {
        return 'security.encoder_factory';
    }
}