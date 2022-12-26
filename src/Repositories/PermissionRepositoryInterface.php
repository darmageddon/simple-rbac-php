<?php

namespace Darmageddon\RBAC\Repositories;

use Darmageddon\RBAC\Entities\PermissionInterface;

interface PermissionRepositoryInterface
{
    /**
     * @param array $filters
     * @return array<PermissionInterface>
     */
    public function get(array $filters): array;

    /**
     * @param PermissionInterface $permission
     * @return null|PermissionInterface
     */
    public function find(PermissionInterface $permission): ?PermissionInterface;

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function exists(PermissionInterface $permission): bool;

    /**
     * @param PermissionInterface $permission
     * @return null|PermissionInterface
     */
    public function persists(PermissionInterface $permission): ?PermissionInterface;

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function delete(PermissionInterface $permission): bool;
}
