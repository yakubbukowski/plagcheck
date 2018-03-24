<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="advantage_group_translation",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="advantage_group_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class AdvantageGroupTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AdvantageGroup", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

}