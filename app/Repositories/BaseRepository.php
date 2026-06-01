<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->findById($id);
        if ($model) {
            return $model->update($attributes);
        }
        return false;
    }

    public function deleteById(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function restoreById(int $id): bool
    {
        return $this->model->withTrashed()->find($id)?->restore() ?? false;
    }

    public function permanentlyDeleteById(int $id): bool
    {
        return $this->model->withTrashed()->find($id)?->forceDelete() ?? false;
    }

    public function findByField(string $field, $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, $value)->first($columns);
    }

    public function findWhere(array $conditions, array $columns = ['*']): Collection
    {
        return $this->model->where($conditions)->get($columns);
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countWhere(array $conditions): int
    {
        return $this->model->where($conditions)->count();
    }

    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }
}