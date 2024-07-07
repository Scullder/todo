<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Models\Task;

class TaskRepository implements TaskRepositoryContract
{
    public function save(array $data): null|array
    {
        $task = Task::create($data);

        return $this->get($task->getKey());
    }

    public function get(mixed $id): mixed
    {
        return Task::find($id);
    }

    public function getAll(array $filters = []): mixed
    {
        return Task::where($filters)->paginate(20);
    }

    public function delete(mixed $id)
    {
        Task::destroy($id);
    }

    public function update(array $data)
    {
        $task = Task::find($data['id']);

        if (!$task) {
            throw new \App\Exceptions\NotFoundException("Task {$data['id']} - Not Found");
        }

        $task->update($data);
    }
}
