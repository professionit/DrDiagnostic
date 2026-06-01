<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;
    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model;
    public function create(array $attributes): Model;
    public function update(int $id, array $attributes): bool;
    public function deleteById(int $id): bool;
    public function findByField(string $field, $value, array $columns = ['*']): ?Model;
    public function findWhere(array $conditions, array $columns = ['*']): Collection;
    public function count(): int;
    public function countWhere(array $conditions): int;
    public function updateOrCreate(array $attributes, array $values = []): Model;
}