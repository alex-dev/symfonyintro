<?php
namespace AppBundle\Entity\Flag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Flag\Flag;

/**
 * @ORM\Entity
 * @ORM\Table(
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="UK_ProductStates_key", columns={ "`key`" }),
 *     @ORM\UniqueConstraint(name="UK_ProductStates_name", columns={ "nameTranslationKey" })
 *   })
 * @UniqueEntity("key")
 * @UniqueEntity("nameTranslationKey")
 */
class ProductState extends Flag { }
