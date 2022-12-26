<?php

namespace Darmageddon\RBAC\Factories;

use Darmageddon\RBAC\Entities\RoleInterface;

interface RoleFactoryInterface
{
    /**
     * @param array $attributes
     * @return RoleInterface
     */
    public function make(array $attributes): RoleInterface;
}
