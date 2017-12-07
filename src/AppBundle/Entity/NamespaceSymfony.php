<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * NamespaceSymfony
 *
 * @ORM\Entity()
 *
 * @Gedmo\Tree(type="nested")
 *
 */
class NamespaceSymfony
{

    /**
     * @var NamespaceSymfony
     *
     * @Gedmo\TreeParent
     *
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="children")
     */
    private $parent;

    /**
     * @var NamespaceSymfony
     *
     * @ORM\OneToMany(targetEntity="NamespaceSymfony", mappedBy="parent")
     *
     * @ORM\OrderBy({"left"="ASC"})
     *
     */
    private $children;
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="InterfaceSymfony", mappedBy="namespace")
     */
    private $interfaces;

    /**
     * NamespaceSymfony constructor.
     */
    public function __construct()
    {
        $this->interfaces = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getInterfaces(): ArrayCollection
    {
        return $this->interfaces;
    }

    /**
     * @return NamespaceSymfony|null
     */
    public function getParent(): ?NamespaceSymfony
    {
        return $this->parent;
    }

    /**
     * @param NamespaceSymfony|null $parent
     *
     * @return NamespaceSymfony
     */
    public function setParent(?NamespaceSymfony $parent): NamespaceSymfony
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return NamespaceSymfony
     */
    public function getChildren(): NamespaceSymfony
    {
        return $this->children;
    }

    /**
     * @param NamespaceSymfony $children
     */
    public function setChildren(NamespaceSymfony $children){
        $this->children = $children;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return NamespaceSymfony
     */
    public function setName(string $name): NamespaceSymfony
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return NamespaceSymfony
     */
    public function setUrl(string $url): NamespaceSymfony
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Add child
     *
     * @param \AppBundle\Entity\NamespaceSymfony $child
     *
     * @return NamespaceSymfony
     */
    public function addChild(\AppBundle\Entity\NamespaceSymfony $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \AppBundle\Entity\NamespaceSymfony $child
     */
    public function removeChild(\AppBundle\Entity\NamespaceSymfony $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Add interface
     *
     * @param \AppBundle\Entity\InterfaceSymfony $interface
     *
     * @return NamespaceSymfony
     */
    public function addInterface(\AppBundle\Entity\InterfaceSymfony $interface)
    {
        $this->interfaces[] = $interface;

        return $this;
    }

    /**
     * Remove interface
     *
     * @param \AppBundle\Entity\InterfaceSymfony $interface
     */
    public function removeInterface(\AppBundle\Entity\InterfaceSymfony $interface)
    {
        $this->interfaces->removeElement($interface);
    }
}
