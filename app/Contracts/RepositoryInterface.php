<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface.
 */
interface RepositoryInterface
{
    public function get(int $id): ?Model;

    public function create(array $data): ?Model;

    public function update(array $data, Model $model): Model;

    public function delete(int $id): bool;
}
