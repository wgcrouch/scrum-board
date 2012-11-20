<?php
namespace itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class BoardRepository extends DocumentRepository
{
    
    public function findAllByTeams($teams)
    {
        $boards = array();
        $ids = array();
        foreach($teams as $team) {
            $ids[] = new \MongoId($team->getId());
        }
        $boards = $this->createQueryBuilder()
            ->field('team.$id')->in($ids)
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();
        return $boards;
    }
    
}

