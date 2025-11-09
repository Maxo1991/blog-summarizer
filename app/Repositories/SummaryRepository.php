<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Summary;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SummaryRepository implements SummaryRepositoryInterface
{
    public function create(array $data): Summary
    {
        return Summary::create($data);
    }

    public function getPaginated(int $perPage = 3): LengthAwarePaginator
    {
        return Summary::latest()->paginate($perPage);
    }
}
