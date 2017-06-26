<?php

namespace SfCmsProject\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Icon
 *
 * @ORM\Table(name="icon")
 * @ORM\Entity(repositoryClass="SfCmsProject\CmsBundle\Repository\IconRepository")
 */
class Icon
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
     * @ORM\Column(name="nameIcon", type="string", length=255)
     */
    private $nameIcon;

    /**
     * @var string
     *
     * @ORM\Column(name="viewIcon", type="string", length=255)
     */
    private $viewIcon;


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
     * Set nameIcon
     *
     * @param string $nameIcon
     *
     * @return Icon
     */
    public function setNameIcon($nameIcon)
    {
        $this->nameIcon = $nameIcon;

        return $this;
    }

    /**
     * Get nameIcon
     *
     * @return string
     */
    public function getNameIcon()
    {
        return $this->nameIcon;
    }

    /**
     * Set viewIcon
     *
     * @param string $viewIcon
     *
     * @return Icon
     */
    public function setViewIcon($viewIcon)
    {
        $this->viewIcon = $viewIcon;

        return $this;
    }

    /**
     * Get viewIcon
     *
     * @return string
     */
    public function getViewIcon()
    {
        return $this->viewIcon;
    }
}
