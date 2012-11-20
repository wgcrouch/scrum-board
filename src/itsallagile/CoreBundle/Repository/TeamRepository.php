<?php
namespace itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use itsallagile\CoreBundle\Document\User;

class TeamRepository extends DocumentRepository
{
    
    public function findAllByUser(User $user)
    {
        $teams = $this->getFindAllByUserQueryBuilder($user)
            ->getQuery()
            ->execute();
        return $teams;
    }
    
    public function getFindAllByUserQueryBuilder(User $user)
    {
        $query = $this->createQueryBuilder()
            ->field('users.$id')->equals($user->getId())
            ->sort('name', 'ASC');
        return $query;
    }
    
}

