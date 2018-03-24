<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Sonata\TranslationBundle\Model\Gedmo\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="advantage_translation",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="advantage_translation_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class AdvantageTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Advantage", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

}