<?php
namespace AppBundle\DataFixtures\ORM;

use SfCmsProject\CmsBundle\Entity\Post;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $post = new Post();
        $post->setName("Titre du 1er article");
        $post->setContent("Je suis un article de test, je permet à l'utilisateur de voir ou se trouvera le contenu de l'article dans l'aperçu de template.");
        $post->setSuppress(true);


        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName("Titre du 2eme article");
        $post->setContent("Je suis un article de test, je permet à l'utilisateur de voir ou se trouvera le contenu de l'article dans l'aperçu de template.");
        $post->setSuppress(true);


        $manager->persist($post);
        $manager->flush();

        $post = new Post();
        $post->setName("Titre du 3eme article");
        $post->setContent("Je suis un article de test, je permet à l'utilisateur de voir ou se trouvera le contenu de l'article dans l'aperçu de template.");
        $post->setSuppress(true);


        $manager->persist($post);
        $manager->flush();
    }


    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 25;
    }

}
