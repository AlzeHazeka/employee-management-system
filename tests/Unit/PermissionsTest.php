<?php

namespace Tests\Unit;

use App\Support\Permissions;
use PHPUnit\Framework\TestCase;

class PermissionsTest extends TestCase
{
    public function test_permission_catalog_contains_unique_known_permissions(): void
    {
        $permissions = Permissions::all();

        $this->assertNotEmpty($permissions);
        $this->assertSame($permissions, array_values(array_unique($permissions)));

        foreach ($permissions as $permission) {
            $this->assertTrue(Permissions::isKnown($permission));
        }
    }

    public function test_unknown_permission_is_rejected(): void
    {
        $this->assertFalse(Permissions::isKnown('portfolio.unknown'));
    }
}
