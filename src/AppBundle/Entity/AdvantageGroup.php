<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/4/2017
 * Time: 6:10 PM
 */

namespace AppBundle\Entity;


use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslatable;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="advantage_group")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\AdvantageGroupTranslation")
 */
class AdvantageGroup extends AbstractPersonalTranslatable implements TranslatableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Advantage", mappedBy="advantageGroup")
     * @ORM\OrderBy({"advantageOrder": "ASC"})
     */
    private $advantage;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Page", mappedBy="advantageGroup")
     */
    private $page;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Translatable
     */
    private $advantageGroupTitle;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     */
    private $advantageGroupText;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\AdvantageGroupTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    /**
     * @return mixed
     */
    public function getAdvantageGroupText()
    {
        return $this->advantageGroupText;
    }

    /**
     * @param mixed $advantageGroupText
     */
    public function setAdvantageGroupText($advantageGroupText)
    {
        $this->advantageGroupText = $advantageGroupText;
    }


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
    public function getAdvantage()
    {
        return $this->advantage;
    }

    /**
     * @param mixed $advantage
     */
    public function setAdvantage($advantage)
    {
        $this->advantage = $advantage;
    }


    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }


    /**
     * @return mixed
     */
    public function getAdvantageGroupTitle()
    {
        return $this->advantageGroupTitle;
    }

    /**
     * @param mixed $advantageGroupTitle
     */
    public function setAdvantageGroupTitle($advantageGroupTitle)
    {
        $this->advantageGroupTitle = $advantageGroupTitle;
    }



}