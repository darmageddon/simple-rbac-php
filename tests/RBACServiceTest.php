<?php

declare(strict_types=1);

namespace Darmageddon\RBAC\Tests;

use PHPUnit\Framework\TestCase;

use Darmageddon\RBAC\Entities\PermissionInterface;
use Darmageddon\RBAC\Entities\RoleInterface;
use Darmageddon\RBAC\Entities\UserInterface;
use Darmageddon\RBAC\Factories\PermissionFactoryInterface;
use Darmageddon\RBAC\Factories\RoleFactoryInterface;
use Darmageddon\RBAC\Repositories\PermissionRepositoryInterface;
use Darmageddon\RBAC\Repositories\RoleRepositoryInterface;
use Darmageddon\RBAC\RBACService;

final class RBACServiceTest extends TestCase
{
    private PermissionInterface $permission;
    private RoleInterface $role;
    private UserInterface $user;
    private RoleFactoryInterface $roleFactory;
    private PermissionFactoryInterface $permissionFactory;
    private RoleRepositoryInterface $roleRepository;
    private PermissionRepositoryInterface $permissionRepository;
    private RBACService $service;

    protected function setUp(): void
    {
        $this->permission = $this->createStub(PermissionInterface::class);
        $this->permissionFactory = $this->createStub(PermissionFactoryInterface::class);
        $this->permissionRepository = $this->createStub(PermissionRepositoryInterface::class);

        $this->role = $this->createStub(RoleInterface::class);
        $this->roleFactory = $this->createStub(RoleFactoryInterface::class);
        $this->roleRepository = $this->createStub(RoleRepositoryInterface::class);

        $this->user = $this->createStub(UserInterface::class);

        $this->service = $this->getMockForAbstractClass(
            originalClassName: RBACService::class,
            arguments: [
                $this->roleFactory,
                $this->permissionFactory,
                $this->roleRepository,
                $this->permissionRepository
            ],
            mockedMethods: [
                'commitCreateRole',
                'commitUpdateRole',
                'commitDeleteRole',
                'commitCreatePermission',
                'commitUpdatePermission',
                'commitDeletePermission'
            ]
        );
    }

    public function test_can_create_role(): void
    {
        $this->roleRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $this->service
            ->expects($this->once())
            ->method('commitCreateRole')
            ->willReturn($this->role);

        $this->assertSame($this->role, $this->service->createRole($this->role));
    }

    public function test_can_create_role_using_string_argument(): void
    {
        $this->roleFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->role);

        $this->roleRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $this->service
            ->expects($this->once())
            ->method('commitCreateRole')
            ->willReturn($this->role);

        $this->assertSame($this->role, $this->service->createRole('Admin'));
    }

    public function test_can_update_role(): void
    {
        $this->role
            ->method('getName')
            ->willReturnOnConsecutiveCalls('Admin', 'Super Admin');
        $this->role
            ->expects($this->once())
            ->method('setName');

        $this->roleRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->role);

        $this->service
            ->expects($this->once())
            ->method('commitUpdateRole')
            ->willReturn($this->role);

        $this->assertSame('Admin', $this->role->getName());
        $updated = $this->service->updateRole($this->role, ['name' => 'Super Admin']);
        $this->assertSame('Super Admin', $updated->getName());
    }

    public function test_can_update_role_using_string_argument(): void
    {
        $this->role
            ->method('getName')
            ->willReturnOnConsecutiveCalls('Admin', 'Super Admin');
        $this->role
            ->expects($this->once())
            ->method('setName');

        $this->roleFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->role);

        $this->roleRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->role);

        $this->service
            ->expects($this->once())
            ->method('commitUpdateRole')
            ->willReturn($this->role);

        $this->assertSame('Admin', $this->role->getName());
        $updated = $this->service->updateRole('Admin', ['name' => 'Super Admin']);
        $this->assertSame('Super Admin', $updated->getName());
    }

    public function test_can_delete_role(): void
    {
        $this->roleRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->role);

        $this->service
            ->expects($this->once())
            ->method('commitDeleteRole')
            ->willReturn(true);

        $this->assertTrue($this->service->deleteRole($this->role));
    }

    public function test_can_delete_role_using_string(): void
    {
        $this->roleFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->role);

        $this->roleRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->role);

        $this->service
            ->expects($this->once())
            ->method('commitDeleteRole')
            ->willReturn(true);

        $this->assertTrue($this->service->deleteRole('Admin'));
    }

    public function test_can_create_permission(): void
    {
        $this->permissionRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $this->service
            ->expects($this->once())
            ->method('commitCreatePermission')
            ->willReturn($this->permission);

        $this->assertSame($this->permission, $this->service->createPermission($this->permission));
    }

    public function test_can_create_permission_using_string_argument(): void
    {
        $this->permissionFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->permission);

        $this->permissionRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $this->service
            ->expects($this->once())
            ->method('commitCreatePermission')
            ->willReturn($this->permission);

        $this->assertSame($this->permission, $this->service->createPermission('user:create'));
    }

    public function test_can_update_permission(): void
    {
        $this->permission
            ->method('getName')
            ->willReturnOnConsecutiveCalls('user:create', 'user:make');
        $this->permission
            ->expects($this->once())
            ->method('setName');

        $this->permissionRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->permission);

        $this->service
            ->expects($this->once())
            ->method('commitUpdatePermission')
            ->willReturn($this->permission);

        $this->assertSame('user:create', $this->permission->getName());
        $updated = $this->service->updatePermission($this->permission, ['name' => 'Super Admin']);
        $this->assertSame('user:make', $updated->getName());
    }

    public function test_can_update_permission_using_string_argument(): void
    {
        $this->permission
            ->method('getName')
            ->willReturnOnConsecutiveCalls('user:create', 'user:make');
        $this->permission
            ->expects($this->once())
            ->method('setName');

        $this->permissionFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->permission);

        $this->permissionRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->permission);

        $this->service
            ->expects($this->once())
            ->method('commitUpdatePermission')
            ->willReturn($this->permission);

        $this->assertSame('user:create', $this->permission->getName());
        $updated = $this->service->updatePermission('user:create', ['name' => 'user:make']);
        $this->assertSame('user:make', $updated->getName());
    }

    public function test_can_delete_permission(): void
    {
        $this->permissionRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->permission);

        $this->service
            ->expects($this->once())
            ->method('commitDeletePermission')
            ->willReturn(true);

        $this->assertTrue($this->service->deletePermission($this->permission));
    }

    public function test_can_delete_permission_using_string_argument(): void
    {
        $this->permissionFactory
            ->expects($this->once())
            ->method('make')
            ->willReturn($this->permission);

        $this->permissionRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->permission);

        $this->service
            ->expects($this->once())
            ->method('commitDeletePermission')
            ->willReturn(true);

        $this->assertTrue($this->service->deletePermission('user:create'));
    }

    public function test_can_assign_role_to_user(): void
    {
        $this->roleRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->user
            ->expects($this->exactly(2))
            ->method('hasRole')
            ->willReturnOnConsecutiveCalls(false, true);
        $this->user
            ->expects($this->once())
            ->method('addRole');

        $this->service
            ->expects($this->once())
            ->method('persistUserRole')
            ->with($this->user);

        $this->service->assignRoleToUser($this->user, $this->role);

        $this->assertTrue($this->user->hasRole($this->role));
    }

    public function test_can_remove_role_from_user(): void
    {
        $this->user
            ->expects($this->exactly(2))
            ->method('hasRole')
            ->willReturnOnConsecutiveCalls(true, false);
        $this->user
            ->expects($this->once())
            ->method('removeRole')
            ->willReturn(true);

        $this->service
            ->expects($this->once())
            ->method('removeUserRole')
            ->with($this->user);

        $this->service->removeRoleFromUser($this->user, $this->role);

        $this->assertFalse($this->user->hasRole($this->role));
    }

    public function test_can_assign_permission_to_role(): void
    {
        $this->permissionRepository
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->role
            ->expects($this->exactly(2))
            ->method('hasPermission')
            ->willReturnOnConsecutiveCalls(false, true);
        $this->role
            ->expects($this->once())
            ->method('addPermission');

        $this->roleFactory
            ->method('make')
            ->willReturn($this->role);

        $this->service
            ->expects($this->once())
            ->method('persistRolePermission')
            ->with($this->role);

        $this->service->assignPermissionToRole($this->role, $this->permission);
        $this->assertTrue($this->role->hasPermission($this->permission));
    }

    public function test_can_remove_permission_from_role(): void
    {
        $this->role
            ->expects($this->exactly(2))
            ->method('hasPermission')
            ->willReturnOnConsecutiveCalls(true, false);
        $this->role
            ->expects($this->once())
            ->method('removePermission')
            ->willReturn(true);

        $this->service
            ->expects($this->once())
            ->method('removeRolePermission')
            ->with($this->role);

        $this->service->removePermissionFromRole($this->role, $this->permission);

        $this->assertFalse($this->role->hasPermission($this->permission));
    }
}
