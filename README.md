
# Simple RBAC Abstraction

Simple role-based access control (RBAC) abstraction in PHP
## Features

- createRole
- updateRole
- deleteRole
- createPermission
- updatePermission
- deletePermission
- assignRoleToUser
- removeRoleFromUser

```php
public function createRole(RoleInterface|string $role): RoleInterface
{
}

public function updateRole(RoleInterface|string $role, array $attributes): RoleInterface
{
}

public function deleteRole(RoleInterface|string $role): bool
{
}

public function createPermission(PermissionInterface|string $permission): PermissionInterface
{
}

public function updatePermission(PermissionInterface|string $permission, array $attributes): PermissionInterface
{
}

public function deletePermission(PermissionInterface|string $permission): bool
{
}

public function assignRoleToUser(UserInterface $user, RoleInterface $role): void
{
}

public function removeRoleFromUser(UserInterface $user, RoleInterface $role): void
{
}
```


## How to Use

#### Extend RBACService Class

```php
    class MyRBACService extends \Darmageddon\RBAC\RBACService
    {
        //
    }
```

#### Implement Interfaces
Implement UserInterface, RoleInterface, and PermissionInterface

#### Override some persistance and removal function

```php
    class MyRBACService extends \Darmageddon\RBAC\RBACService
    {
        // Must Override
        protected function persistUserRole(UserInterface $user): void
        {
            //
        }
        
        protected function removeUserRole(UserInterface $user): void
        {
            //
        }
        
        protected function persistRolePermission(RoleInterface $role): void
        {
            //
        }
        
        protected function removeRolePermission(RoleInterface $role): void
        {
            //
        }

        // Other overridable functions
        protected function commitCreateRole(RoleInterface $role): RoleInterface
        {
            //
        }

        protected function commitUpdateRole(RoleInterface $role, array $attributes): RoleInterface
        {
            //
        }

        protected function commitDeleteRole(RoleInterface $role): bool
        {
            //
        }

        protected function commitCreatePermission(PermissionInterface $permission): PermissionInterface
        {
            //
        }

        protected function commitUpdatePermission(PermissionInterface $permission, array $attributes): PermissionInterface
        {
            //
        }

        protected function commitDeletePermission(PermissionInterface $permission): bool
        {
            //
        }
    }
```