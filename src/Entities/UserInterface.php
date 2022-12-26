<?php

namespace Darmageddon\RBAC\Entities;

interface UserInterface
{
    /**
     * @return array<RoleInterface>
     */
    public function getRoles(): array;

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function hasRole(RoleInterface $role): bool;

    /**
     * @param RoleInterface $role
     * @return RoleInterface
     */
    public function addRole(RoleInterface $role): RoleInterface;

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function removeRole(RoleInterface $role): bool;

    /**
     * @return RoleInterface
     */
    public function getActiveRole(): RoleInterface;

    /**
     * @param RoleInterface $role
     * @return void
     */
    public function setActiveRole(RoleInterface $role): void;

    /**
     * @param PermissionInterface $permission
     * @return bool
     */
    public function isPermitted(PermissionInterface $permission): bool;
}
