<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Summary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SummaryRepositoryInterface
{
    public function create(array $data): Summary;

    public function getPaginated(int $perPage = 3): LengthAwarePaginator;
}
