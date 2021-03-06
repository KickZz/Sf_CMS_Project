<?php

namespace SfCmsProject\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="SfCmsProject\CmsBundle\Repository\PageRepository")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="orderMenu", type="integer")
     */
    private $orderMenu;

    /**
     * @var bool
     *
     * @ORM\Column(name="insideMenu", type="boolean")
     */
    private $insideMenu;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="SfCmsProject\CmsBundle\Entity\Template", inversedBy="page")
     */

    private $template;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="keyWord", type="array", nullable=true)
     */
    private $keyWord;

    /**
     * @var bool
     *
     * @ORM\Column(name="isHome", type="boolean", nullable=true)
     */
    private $isHome;

    /**
     * @var bool
     *
     * @ORM\Column(name="contentPost", type="boolean", nullable=true)
     */
    private $contentPost;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=true)
     */
    private $disabled;

    /**
     * @var string
     *
     * @ORM\Column(name="myClassIcon", type="string", length=100, nullable=true)
     */
    private $myClassIcon;

    /**
     * @var int
     *
     * @ORM\Column(name="idSubMenu", type="integer", nullable=true)
     */
    private $idSubMenu;

    /**
     * @var bool
     *
     * @ORM\Column(name="insideSubMenu", type="boolean", nullable=true)
     */
    private $insideSubMenu;

    /**
     * @var bool
     *
     * @ORM\Column(name="haveSubPage", type="boolean", nullable=true)
     */
    private $haveSubPage;

    /**
     * @var int
     *
     * @ORM\Column(name="numberSubPage", type="integer", nullable=true)
     */
    private $numberSubPage;


    public function __construct()
    {

        $this->disabled = false;
        $this->orderMenu = 10000;
        $this->insideMenu = false;
        $this->insideSubMenu = false;
        $this->haveSubPage = false;
        $this->numberSubPage = 0;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set keyWord
     *
     * @param array $keyWord
     *
     * @return Page
     */
    public function setKeyWord($keyWord)
    {
        $this->keyWord = $keyWord;

        return $this;
    }

    /**
     * Get keyWord
     *
     * @return array
     */
    public function getKeyWord()
    {
        return $this->keyWord;
    }

    /**
     * Set isHome
     *
     * @param boolean $isHome
     *
     * @return Page
     */
    public function setIsHome($isHome)
    {
        $this->isHome = $isHome;

        return $this;
    }

    /**
     * Get isHome
     *
     * @return bool
     */
    public function getIsHome()
    {
        return $this->isHome;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return Page
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set order
     *
     * @param integer $orderMenu
     *
     * @return Page
     */
    public function setOrderMenu($orderMenu)
    {
        $this->orderMenu = $orderMenu;

        return $this;
    }

    /**
     * Get orderMenu
     *
     * @return integer
     */
    public function getOrderMenu()
    {
        return $this->orderMenu;
    }

    /**
     * Set insideMenu
     *
     * @param boolean $insideMenu
     *
     * @return Page
     */
    public function setInsideMenu($insideMenu)
    {
        $this->insideMenu = $insideMenu;

        return $this;
    }

    /**
     * Get insideMenu
     *
     * @return boolean
     */
    public function getInsideMenu()
    {
        return $this->insideMenu;
    }

    /**
     * Set myClassIcon
     *
     * @param string $myClassIcon
     *
     * @return Page
     */
    public function setMyClassIcon($myClassIcon)
    {
        $this->myClassIcon = $myClassIcon;

        return $this;
    }

    /**
     * Get myClassIcon
     *
     * @return string
     */
    public function getMyClassIcon()
    {
        return $this->myClassIcon;
    }

    /**
     * Set idSubMenu
     *
     * @param integer $idSubMenu
     *
     * @return Page
     */
    public function setIdSubMenu($idSubMenu)
    {
        $this->idSubMenu = $idSubMenu;

        return $this;
    }

    /**
     * Get idSubMenu
     *
     * @return integer
     */
    public function getIdSubMenu()
    {
        return $this->idSubMenu;
    }

    /**
     * Set insideSubMenu
     *
     * @param boolean $insideSubMenu
     *
     * @return Page
     */
    public function setInsideSubMenu($insideSubMenu)
    {
        $this->insideSubMenu = $insideSubMenu;

        return $this;
    }

    /**
     * Get insideSubMenu
     *
     * @return boolean
     */
    public function getInsideSubMenu()
    {
        return $this->insideSubMenu;
    }

    /**
     * Set haveSubPage
     *
     * @param boolean $haveSubPage
     *
     * @return Page
     */
    public function setHaveSubPage($haveSubPage)
    {
        $this->haveSubPage = $haveSubPage;

        return $this;
    }

    /**
     * Get haveSubPage
     *
     * @return boolean
     */
    public function getHaveSubPage()
    {
        return $this->haveSubPage;
    }

    /**
     * Set numberSubPage
     *
     * @param integer $numberSubPage
     *
     * @return Page
     */
    public function setNumberSubPage($numberSubPage)
    {
        $this->numberSubPage = $numberSubPage;

        return $this;
    }

    /**
     * Get numberSubPage
     *
     * @return integer
     */
    public function getNumberSubPage()
    {
        return $this->numberSubPage;
    }

    /**
     * Set template
     *
     * @param \SfCmsProject\CmsBundle\Entity\Template $template
     *
     * @return Page
     */
    public function setTemplate(\SfCmsProject\CmsBundle\Entity\Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \SfCmsProject\CmsBundle\Entity\Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set contentPost
     *
     * @param boolean $contentPost
     *
     * @return Page
     */
    public function setContentPost($contentPost)
    {
        $this->contentPost = $contentPost;

        return $this;
    }

    /**
     * Get contentPost
     *
     * @return boolean
     */
    public function getContentPost()
    {
        return $this->contentPost;
    }
}
