<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/4/2017
 * Time: 6:12 PM
 */

namespace AppBundle\Entity;


use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="advantage")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\AdvantageTranslation")
 */
class Advantage extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AdvantageGroup", inversedBy="advantage")
     */
    private $advantageGroup;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Icon", inversedBy="advantage")
     */
    private $icon;


    /**
     * @ORM\Column(type="integer")
     */
    private $advantageOrder;


    /**
     * @ORM\Column(type="string")
     * @Gedmo\Translatable
     */private $advantageTitle;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     */
    private $advantageText;

    /**
     * @ORM\Column(type="string")
     */
    private $advantageLink;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\AdvantageTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAdvantageGroup()
    {
        return $this->advantageGroup;
    }

    /**
     * @param mixed $advantageGroup
     */
    public function setAdvantageGroup($advantageGroup)
    {
        $this->advantageGroup = $advantageGroup;
    }


    /**
     * @return mixed
     */
    public function getAdvantageOrder()
    {
        return $this->advantageOrder;
    }

    /**
     * @param mixed $advantageOrder
     */
    public function setAdvantageOrder($advantageOrder)
    {
        $this->advantageOrder = $advantageOrder;
    }

    /**
     * @return mixed
     */
    public function getAdvantageTitle()
    {
        return $this->advantageTitle;
    }

    /**
     * @param mixed $advantageTitle
     */
    public function setAdvantageTitle($advantageTitle)
    {
        $this->advantageTitle = $advantageTitle;
    }

    /**
     * @return mixed
     */
    public function getAdvantageText()
    {
        return $this->advantageText;
    }

    /**
     * @param mixed $advantageText
     */
    public function setAdvantageText($advantageText)
    {
        $this->advantageText = $advantageText;
    }

    /**
     * @return mixed
     */
    public function getAdvantageLink()
    {
        return $this->advantageLink;
    }

    /**
     * @param mixed $advantageLink
     */
    public function setAdvantageLink($advantageLink)
    {
        $this->advantageLink = $advantageLink;
    }


    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }



}