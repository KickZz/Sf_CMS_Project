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
     * @ORM\Column(name="contentArticle", type="boolean")
     */
    private $contentArticle;

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
     * @ORM\Column(name="isHome", type="boolean")
     */
    private $isHome;


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
     * Set contentArticle
     *
     * @param boolean $contentArticle
     *
     * @return Page
     */
    public function setContentArticle($contentArticle)
    {
        $this->contentArticle = $contentArticle;

        return $this;
    }

    /**
     * Get contentArticle
     *
     * @return bool
     */
    public function getContentArticle()
    {
        return $this->contentArticle;
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
}

