<?php
namespace AppBundle\DataFixtures\ORM;

use SfCmsProject\CmsBundle\Entity\Page;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $page = new Page();
        $page->setName("Titre de la Page");
        $page->setContent("Je suis une page de test, je permet à l'utilisateur de voir ou se trouvera le contenu de la page dans l'aperçu de template.");
        $page->setDisabled(true);
        $page->setOrderMenu(10000);
        $page->setInsideMenu(false);
        $page->setInsideSubMenu(false);
        $page->setHaveSubPage(false);
        $page->setNumberSubPage(0);


        $manager->persist($page);
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
