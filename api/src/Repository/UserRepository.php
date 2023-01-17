<?php
# api/src/Repository/UserRepository.php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    /**
     * Generate a token for email verification or password reset
     */
    public function generateToken(): string {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    private function findByRole(string $role, $active)
    {
        $resultSet = new ResultSetMapping;

        $resultSet->addEntityResult(User::class, 'u');
        $resultSet->addFieldResult('u', 'id', 'id');
        $resultSet->addFieldResult('u', 'email', 'email');
        $resultSet->addFieldResult('u', 'roles', 'roles');
        $resultSet->addFieldResult('u', 'password', 'password');
        $resultSet->addFieldResult('u', 'created_at', 'createdAt');
        $resultSet->addFieldResult('u', 'updated_at', 'updatedAt');
        $resultSet->addFieldResult('u', 'deleted_at', 'deletedAt');
        $resultSet->addFieldResult('u', 'is_active', 'isActive');

        $sql = "SELECT * FROM user WHERE roles LIKE '%\"$role\"%'";

        if (is_bool($active)) {
            $sql .= ' AND is_active = ' . ($active ? 'true' : 'false');
        }

        return $this->getEntityManager()->createNativeQuery($sql, $resultSet)->getResult();
    }

    public function findAdmins(bool $active = null)
    {
        return $this->findByRole('ROLE_ADMIN', $active);
    }

    public function findOwners(bool $active = null)
    {
        return $this->findByRole('ROLE_OWNER', $active);
    }

    public function findCustomers(bool $active = null)
    {
        return $this->findByRole('ROLE_CUSTOMER', $active);
    }
}
