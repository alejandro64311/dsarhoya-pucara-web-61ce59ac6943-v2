<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Alert.
 *
 * @ORM\Table(name="alert")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlertRepository")
 */
class Alert
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
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $severity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     */
    private $mine;

    /*
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set severity.
     *
     * @param int $severity
     *
     * @return Alert
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * Get severity.
     *
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set icon.
     *
     * @param string $icon
     *
     * @return Alert
     */
    public function setIcon($icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Alert
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Alert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return Alert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set mine.
     *
     * @return Alert
     */
    public function setMine(\AppBundle\Entity\Mine $mine = null)
    {
        $this->mine = $mine;

        return $this;
    }

    /**
     * Get mine.
     *
     * @return \AppBundle\Entity\Mine|null
     */
    public function getMine()
    {
        return $this->mine;
    }
}
