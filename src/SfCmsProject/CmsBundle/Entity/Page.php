<?php

namespace SfCmsProject\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="contentPost", type="boolean", nullable=true)
     */
    private $contentPost;

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
     * @ORM\Column(name="disabled", type="boolean", nullable=true)
     */
    private $disabled;


    public function __construct()
    {

        $this->disabled = false;

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
     * @return bool
     */
    public function getContentPost()
    {
        return $this->contentPost;
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
}
