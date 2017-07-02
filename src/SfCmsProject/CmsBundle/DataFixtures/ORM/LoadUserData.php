<?php
namespace AppBundle\DataFixtures\ORM;

use SfCmsProject\CmsBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On crée l'utilisateur
        $user = new User;

        // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
        $user->setUsername("Admin");

        // On ne se sert pas du sel pour l'instant
        // on définit un nom unique grâce à une chaine aléatoire de 16 caractères
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );
        $str= '';
        for( $i = 0; $i < 16; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        $user->setSalt($str);
        $user->setPlainTextPassword("password00");
        $user->setPassword(md5($str.$user->getPlainTextPassword()));
        // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setEmail('admin@test.com');
        $user->setSignature('Administrateur');
        // On le persiste
        $manager->persist($user);


        // On déclenche l'enregistrement
        $manager->flush();
    }
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 30;
    }
}