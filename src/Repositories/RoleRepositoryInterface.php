<?php

namespace Darmageddon\RBAC\Repositories;

use Darmageddon\RBAC\Entities\RoleInterface;

interface RoleRepositoryInterface
{
    /**
     * @param array $filters
     * @return array<RoleInterface>
     */
    public function get(array $filters): array;

    /**
     * @param RoleInterface $role
     * @return null|RoleInterface
     */
    public function find(RoleInterface $role): ?RoleInterface;

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function exists(RoleInterface $role): bool;

    /**
     * @param RoleInterface $role
     * @return null|RoleInterface
     */
    public function persists(RoleInterface $role): ?RoleInterface;

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function delete(RoleInterface $role): bool;
}
