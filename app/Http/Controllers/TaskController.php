<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\TaskRepositoryContract;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\FilterTrait;

class TaskController extends Controller
{
    use FilterTrait;

    protected $allowedFilterColumns = [
        'status' => ['eq'],
        'deadline' => ['eq'],
    ];

    public function __construct(private TaskRepositoryContract $repository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return TaskResource::collection($this->repository->getAll($this->getFilters($request)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->repository->save($request->validated());

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = $this->repository->get($id);

        if (!$task) {
            return response([
                'message' => 'Not Found',
            ], 404);
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        try {
            $this->repository->update(array_merge($request->all(), [
                'id' => $id,
            ]));
        } catch (NotFoundException $e) {
            return response([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repository->delete($id);
    }
}
