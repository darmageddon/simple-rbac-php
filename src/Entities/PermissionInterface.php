<?php

namespace Darmageddon\RBAC\Entities;

interface PermissionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;
}
