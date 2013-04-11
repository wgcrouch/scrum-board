<?php
namespace Itsallagile\CoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Itsallagile\CoreBundle\Document\User;

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
            ->field('users.$id')->equals(new \MongoId($user->getId()))
            ->sort('name', 'ASC');

        return $query;
    }
}
