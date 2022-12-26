<?php

namespace Darmageddon\RBAC\Factories;

use Darmageddon\RBAC\Entities\PermissionInterface;

interface PermissionFactoryInterface
{
    /**
     * @param array $attributes
     * @return PermissionInterface
     */
    public function make(array $attributes): PermissionInterface;
}
