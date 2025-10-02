<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Services\ProjectService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        $project = $this->service->getById($id);
        if (!$project) return response()->json(['error' => 'Not found project'], 404);
        return response()->json($project);
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
        $project = $this->service->create($request->all());
        return response()->json($project, 201);
    }

    public function update(Request $request, $id)
    {
        $project = $this->service->update($id, $request->all());
        if (!$project) return response()->json(['error' => 'Not found project'], 404);
        return response()->json($project);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['error' => 'Not found project'], 404);
        return response()->json(['message' => 'Deleted']);
    }

    public function deleteSoft($id)
    {
        $deleted = $this->service->deleteSoft($id);
        if (!$deleted) return response()->json(['error' => 'Not found project'], 404);
        return response()->json(['message' => 'Deleted']);
    }

    public function addMemberInProject($projectId, $userId)
    {
        try {
            $userId = $this->service->addMemberInProject($userId, $projectId);
            return response()->json($userId);
        } catch (\Exception $e) {
            Log::error('Add members failed', [
                'projectId' => $projectId,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function removeMemberInProject($projectId, $userId)
    {
        try {
            $userId = $this->service->removeMemberInProject($projectId, $userId);
            return response()->json($userId);
        } catch (\Exception $e) {
            Log::error('Remove members failed', [
                'projectId' => $projectId,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');              // từ khóa tìm kiếm
        $perPage = $request->input('per_page', 10);  // mặc định 10 item/trang
        Log::info("Keyword: " . $keyword);

        $result = $this->service->search($keyword, $perPage);

        // format JSON gọn gàng
        return response()->json([
            'data' => $result->items(),
            'meta' => [
                'current_page' => $result->currentPage(),
                'per_page'     => $result->perPage(),
                'total'        => $result->total(),
                'last_page'    => $result->lastPage(),
            ]
        ]);
    }


    public function searchPeopleNotInProject(Request $request, $projectId)
    {
        $keyword = $request->input('keyword');              // từ khóa tìm kiếm
        $perPage = $request->input('per_page', 10);  // mặc định 10 item/trang

        $result = $this->service->searchPeopleNotInProject($keyword, $perPage, $projectId);
        Log::info("Search request", [
            'keyword' => $keyword,   // log thêm dữ liệu
            'perPage' => $perPage,
            'porjetc' => $projectId
        ]);        // format JSON gọn gàng
        return response()->json([
            'data' => $result->items(),
            'meta' => [
                'current_page' => $result->currentPage(),
                'per_page'     => $result->perPage(),
                'total'        => $result->total(),
                'last_page'    => $result->lastPage(),
            ]
        ]);
    }
}
