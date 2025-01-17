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

    //    /**
    //     * @return Jeu[] Returns an array of Jeu objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findOneBySomeField(?string $nom, ?int $nbParticipant, ?string $type): array
    // public function findOneBySomeField(?string $nom, ?int $nbParticipant, ?int $nbDes, ?int $nbCarte, ?bool $duel, ?string $type): ?Jeu
    {
        $qb = $this->createQueryBuilder('j');

        // if ($nom || $nbParticipant || $nbDes || $nbCarte || $duel || $type) {
        if ($nom || $nbParticipant || $type) {
            $res = $qb->expr()->orX();

            if ($nom !== null) {
                $res->add($qb->expr()->like('j.nom', ':nom'));
                $qb->setParameter('nom', "%$nom%");
            }

            if ($nbParticipant !== null) {
                $res->add($qb->expr()->like("j.nbParticipant",":nbParticipant"));
                $qb->setParameter("nbParticipant", $nbParticipant);
            }

            if ($type !== null) {
                $res->add($qb->expr()->like('j.type', ':type'));
                $qb->setParameter("type", $type);
            }

            /* $res->addMultiple([
                ,
                $qb->expr()->eq('j.nbParticipant', ':nbParticipant'),
                $qb->expr()->eq('j.nbDes', ':nbDes'),
                $qb->expr()->eq('j.nbCarte', ':nbCarte'),
                $qb->expr()->eq('j.duel', ':duel'),
                $qb->expr()->eq('j.type', ':type'),
            ]); */

            /* $qb->setParameters(new ArrayCollection([
                new Parameter('nom', "%$nom%"),
                new Parameter('nbParticipant', "$nbParticipant"),
                new Parameter('nbDes', "$nbDes"),
                new Parameter('nbCarte', "$nbCarte"),
                new Parameter('duel', "$duel"),
                new Parameter('type', "$type"),
            ])); */
        }
            
        
        $qb->where($res);
        // $qb->where($qb->expr()->like('j.nom', ':nom'))
            // ->setParameter('nom', "%$nom%");
            
        return $qb->getQuery()->getResult();
    }

}
