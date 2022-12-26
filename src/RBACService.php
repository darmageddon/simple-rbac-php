<?php

namespace Darmageddon\RBAC;

use Darmageddon\RBAC\RBACExeption;
use Darmageddon\RBAC\Entities\PermissionInterface;
use Darmageddon\RBAC\Entities\RoleInterface;
use Darmageddon\RBAC\Entities\UserInterface;
use Darmageddon\RBAC\Factories\PermissionFactoryInterface;
use Darmageddon\RBAC\Factories\RoleFactoryInterface;
use Darmageddon\RBAC\Repositories\PermissionRepositoryInterface;
use Darmageddon\RBAC\Repositories\RoleRepositoryInterface;

abstract class RBACService
{
    public function __construct(
        private RoleFactoryInterface $roleFactory,
        private PermissionFactoryInterface $permissionFactory,
        private RoleRepositoryInterface $roleRepository,
        private PermissionRepositoryInterface $permissionRepository
    ) {
    }

    /**
     * Create a role and persist it
     * 
     * @param RoleInterface|string $role
     * @return null|RoleInterface
     * @throws RBACExeption
     */
    public function createRole(RoleInterface|string $role): RoleInterface
    {
        if (is_string($role)) {
            $role = $this->roleFactory->make([
                'name' => $role
            ]);
        }

        if ($this->roleRepository->exists($role)) {
            throw new RBACExeption(
                message: "Role {$role->getName()} already exists.",
                code: 202
            );
        }

        return $this->commitCreateRole(
            role: $role
        );
    }

    /**
     * Create a role and persist it
     * 
     * @param RoleInterface|string $role
     * @param array $attributes
     * @return RoleInterface
     * @throws RBACExeption
     */
    public function updateRole(RoleInterface|string $role, array $attributes): RoleInterface
    {
        if (is_string($role)) {
            $role = $this->roleFactory->make([
                'name' => $role
            ]);
        }

        if (is_null($role = $this->roleRepository->find($role))) {
            throw new RBACExeption(
                message: "Role not found."
            );
        }

        if (isset($attributes['name'])) {
            $role->setName(
                name: $attributes['name']
            );
        }

        return $this->commitUpdateRole(
            role: $role,
            attributes: $attributes
        );
    }

    /**
     * Create a role and persist it
     * 
     * @param RoleInterface|string $role
     * @param array $attributes
     * @return RoleInterface
     * @throws RBACExeption
     */
    public function deleteRole(RoleInterface|string $role): bool
    {
        if (is_string($role)) {
            $role = $this->roleFactory->make([
                'name' => $role
            ]);
        }

        if (is_null($role = $this->roleRepository->find($role))) {
            throw new RBACExeption(
                message: "Role not found."
            );
        }

        return $this->commitDeleteRole(
            role: $role
        );
    }

    /**
     * Create a permission and persist it
     * 
     * @param PermissionInterface|string $role
     * @return null|PermissionInterface
     * @throws RBACExeption
     */
    public function createPermission(PermissionInterface|string $permission): PermissionInterface
    {
        if (is_string($permission)) {
            $permission = $this->permissionFactory->make([
                'name' => $permission
            ]);
        }

        if ($this->permissionRepository->exists($permission)) {
            throw new RBACExeption(
                message: "Permission {$permission->getName()} already exists."
            );
        }

        return $this->commitCreatePermission(
            permission: $permission
        );
    }

    /**
     * Create a role and persist it
     * 
     * @param PermissionInterface|string $permission
     * @param array $attributes
     * @return PermissionInterface
     * @throws RBACExeption
     */
    public function updatePermission(PermissionInterface|string $permission, array $attributes): PermissionInterface
    {
        if (is_string($permission)) {
            $permission = $this->permissionFactory->make([
                'name' => $permission
            ]);
        }

        if (is_null($permission = $this->permissionRepository->find($permission))) {
            throw new RBACExeption(
                message: "Permission not found."
            );
        }

        if (isset($attributes['name'])) {
            $permission->setName(
                name: $attributes['name']
            );
        }

        return $this->commitUpdatePermission(
            permission: $permission,
            attributes: $attributes
        );
    }

    /**
     * Create a permission and persist it
     * 
     * @param PermissionInterface|string $permission
     * @param array $attributes
     * @return PermissionInterface
     * @throws RBACExeption
     */
    public function deletePermission(PermissionInterface|string $permission): bool
    {
        if (is_string($permission)) {
            $permission = $this->permissionFactory->make([
                'name' => $permission
            ]);
        }

        if (is_null($permission = $this->permissionRepository->find($permission))) {
            throw new RBACExeption(
                message: "Permission not found."
            );
        }

        return $this->commitDeletePermission(
            permission: $permission
        );
    }

    /**
     * Assign a role to user
     * 
     * @param UserInterface $user
     * @param RoleInterface $role
     * @return void
     * @throws RBACExeption
     */
    public function assignRoleToUser(UserInterface $user, RoleInterface $role): void
    {
        if ($user->hasRole($role)) {
            throw new RBACExeption(
                message: "Role {$role->getName()} already assigned to user."
            );
        }

        if (!$this->roleRepository->exists($role)) {
            throw new RBACExeption(
                message: "Role not found."
            );
        }

        $user->addRole($role);

        $this->persistUserRole($user);
    }

    /**
     * Remove a role from user
     * 
     * @param UserInterface $user
     * @param RoleInterface $role
     * @return void
     * @throws RBACExeption
     */
    public function removeRoleFromUser(UserInterface $user, RoleInterface $role): void
    {
        if (!$user->hasRole($role)) {
            throw new RBACExeption(
                message: "User does not have role {$role->getName()}."
            );
        }

        $user->removeRole($role);

        $this->removeUserRole($user);
    }

    /**
     * Assign a permission to role
     * 
     * @param RoleInterface $role
     * @param PermissionInterface $permission
     * @return void
     * @throws RBACExeption
     */
    public function assignPermissionToRole(RoleInterface $role, PermissionInterface $permission): void
    {
        if ($role->hasPermission($permission)) {
            throw new RBACExeption(
                message: "Permission {$permission->getName()} already assigned to role {$role->getName()}."
            );
        }

        if (!$this->permissionRepository->exists($permission)) {
            throw new RBACExeption(
                message: "Permission not found."
            );
        }

        $role->addPermission($permission);

        $this->persistRolePermission($role);
    }

    /**
     * Remove a permission from role
     * 
     * @param RoleInterface $role
     * @param PermissionInterface $permission
     * @return void
     * @throws RBACExeption
     */
    public function removePermissionFromRole(RoleInterface $role, PermissionInterface $permission): void
    {
        if (!$role->hasPermission($permission)) {
            throw new RBACExeption(
                message: "Role does not have permission {$permission->getName()}."
            );
        }

        $role->removePermission($permission);

        $this->removeRolePermission($role);
    }

    /**
     * Prepare and commit creating role
     * 
     * @param RoleInterface $role
     * @return RoleInterface
     */
    protected function commitCreateRole(RoleInterface $role): RoleInterface
    {
        return $this->roleRepository->persists(
            role: $role
        );
    }

    /**
     * Prepare and commit updating role
     * 
     * @param RoleInterface $role
     * @param array $attributes
     * @return RoleInterface
     */
    protected function commitUpdateRole(RoleInterface $role, array $attributes): RoleInterface
    {
        return $this->roleRepository->persists(
            role: $role
        );
    }

    /**
     * Prepare and commit deleting role
     * 
     * @param RoleInterface $role
     * @return bool
     */
    protected function commitDeleteRole(RoleInterface $role): bool
    {
        return $this->roleRepository->delete(
            role: $role
        );
    }

    /**
     * Prepare and commit creating permission
     * 
     * @param PermissionInterface $permission
     * @return PermissionInterface
     */
    protected function commitCreatePermission(PermissionInterface $permission): PermissionInterface
    {
        return $this->permissionRepository->persists(
            permission: $permission
        );
    }

    /**
     * Prepare and commit updating permission
     * 
     * @param PermissionInterface $permission
     * @param array $attributes
     * @return PermissionInterface
     */
    protected function commitUpdatePermission(PermissionInterface $permission, array $attributes): PermissionInterface
    {
        return $this->permissionRepository->persists(
            permission: $permission
        );
    }

    /**
     * Prepare and commit deleting permission
     * 
     * @param PermissionInterface $permission
     * @return bool
     */
    protected function commitDeletePermission(PermissionInterface $permission): bool
    {
        return $this->permissionRepository->delete(
            permission: $permission
        );
    }

    abstract protected function persistUserRole(UserInterface $user): void;

    abstract protected function removeUserRole(UserInterface $user): void;

    abstract protected function persistRolePermission(RoleInterface $role): void;

    abstract protected function removeRolePermission(RoleInterface $role): void;
}
