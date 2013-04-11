<?php
namespace Itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class BoardRepository extends DocumentRepository
{

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
