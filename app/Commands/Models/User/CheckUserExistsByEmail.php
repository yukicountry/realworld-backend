<?php declare(strict_types=1);

namespace App\Commands\Models\User;

interface CheckUserExistsByEmail
{
    public function handle(string $email): bool;
}
