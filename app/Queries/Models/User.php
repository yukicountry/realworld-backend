<?php declare(strict_types=1);

namespace App\Queries\Models;

final class User
{
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $token,
        public readonly ?string $bio,
        public readonly ?string $image,
    ) {}
}
