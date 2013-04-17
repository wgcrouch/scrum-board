<?php
namespace Itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class BoardRepository extends DocumentRepository
{

    public function findByIdOrSlug($idSlug)
    {
        $qb = $this->createQueryBuilder();
        $qb->addOr($qb->expr()->field('_id')->equals($idSlug));
        $qb->addOr($qb->expr()->field('slug')->equals($idSlug));
        $board = $qb->getQuery()->getSingleResult();
        return $board;
    }

    public function findAllByTeams($teams)
    {
        $ids = array();
        foreach ($teams as $team) {
            $ids[] = new \MongoId($team->getId());
        }
        $boards = $this->createQueryBuilder()
            ->field('team.$id')->in($ids)
            ->sort('created', 'DESC')
            ->getQuery()
            ->execute();
        return $boards;
    }
}
