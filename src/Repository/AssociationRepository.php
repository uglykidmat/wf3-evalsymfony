<?php

namespace App\Repository;

use App\Entity\Conducteur;
use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class AssociationRepository extends ServiceEntityRepository
{public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conducteur::class, Vehicule::class);
    }

}