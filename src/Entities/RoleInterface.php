<?php

namespace Darmageddon\RBAC\Entities;

interface RoleInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName (string $name): void;

    /**
     * @return array<PermissionInterface>
     */
    public function getPermissions(): array;

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function hasPermission(PermissionInterface $permission): bool;

    /**
     * @param PermissionInterface $permission
     * @return PermissionInterface
     */
    public function addPermission(PermissionInterface $permission): PermissionInterface;

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function removePermission(PermissionInterface $permission): bool;
}
