<?php

namespace App\Contracts\Repositories;

interface TaskRepositoryContract
{
    public function save(array $data): mixed;

    public function get(mixed $id): mixed;

    public function getAll(array $filters): mixed;

    public function delete(mixed $id);

    public function update(array $data);
}
