<?php

namespace App\Repository;

use App\Entity\Jeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jeu>
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }

    public function findByFiltre(?string $nom, ?int $nbParticipant): array
    {
        $qb = $this->createQueryBuilder('j');
        $res = $qb->expr()->orX();
        
        if ($nom || $nbParticipant) {

            if ($nom !== null) {
                $res->add($qb->expr()->like('j.nom', ':nom'));
                $qb->setParameter('nom', "%$nom%");
            }

            if ($nbParticipant !== null) {
                $res->add($qb->expr()->like("j.nbParticipant",":nbParticipant"));
                $qb->setParameter("nbParticipant", $nbParticipant);
            }
        }
        
        $qb->where($res);

        return $qb->getQuery()->getResult();
    }

}
