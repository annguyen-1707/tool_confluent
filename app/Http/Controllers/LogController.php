<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\search;

class LogController extends Controller
{
    protected $service;

    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        $Log = $this->service->getById($id);
        if (!$Log) return response()->json(['error' => 'Not found Log'], 404);
        return response()->json($Log);
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title'       => 'required|string|max:255',
        //     'start_date'  => 'nullable|date',
        //     'end_date'    => 'nullable|date|after_or_equal:start_date',
        //     'description' => 'nullable|string',
        //     'status'      => ['required', new Enum(Status::class)],
        //     'created_by'  => 'required|string',
        // ]);
        $Log = $this->service->create($request->all());
        return response()->json($Log, 201);
    }

    public function update(Request $request, $id)
    {
        $Log = $this->service->update($id, $request->all());
        if (!$Log) return response()->json(['error' => 'Not found Log'], 404);
        return response()->json($Log);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['error' => 'Not found Log'], 404);
        return response()->json(['message' => 'Deleted']);
    }

    public function search(Request $request)
    {
        $conditions = $request->only([
            'project_id',
            'node_id',
            '_id',
            'disable'
        ]);             // từ khóa tìm kiếm
        $result = $this->service->findByFields($conditions);

        return response()->json([
            'success' => true,
            'data'    => $result
        ]);
    }
}
