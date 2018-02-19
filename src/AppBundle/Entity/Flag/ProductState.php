<?php
namespace AppBundle\Entity\Flag;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Flag\Flag;
/**
 * @ORM\Entity
 */
class ProductState extends Flag { }
