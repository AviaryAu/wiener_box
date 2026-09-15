<?php

namespace App\Policies;

use Lunar\Admin\Models\Staff;

class BusinessDataPolicy
{
    public function before(Staff $staff): ?bool
    {
        return $staff->admin ? true : null;
    }

    public function viewAny(Staff $staff): bool
    {
        return false;
    }

    public function __call(string $method, array $arguments): bool
    {
        return false;
    }
}
