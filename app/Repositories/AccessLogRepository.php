<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AccessLog;

class AccessLogRepository
{
    public function create(array $data): bool
    {
        return (bool) AccessLog::create($data);
    }
}
