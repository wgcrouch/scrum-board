<?php
namespace itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class TeamRepository extends DocumentRepository
{
    
    public function findAllByUser(\itsallagile\CoreBundle\Document\User $user)
    {
        $teams = $this->createQueryBuilder()
            ->field('users.$id')->equals($user->getId())
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();
        return $teams;
    }
    
}

