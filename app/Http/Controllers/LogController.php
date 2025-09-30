<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    protected $service;

    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $userId = $request->get('user_id');
        $projectId = $request->get('project_id');
        $type = $request->get('type');
        
        $logs = $this->service->getAll($perPage, $userId, $projectId, $type);
        return response()->json($logs);
    }

    public function myLogs(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $userId = auth()->id();
        
        $logs = $this->service->getByUserId($userId, $perPage);
        return response()->json($logs);
    }

    public function projectLogs(Request $request, $projectId)
    {
        $perPage = $request->get('per_page', 10);
        
        $logs = $this->service->getByProjectId($projectId, $perPage);
        return response()->json($logs);
    }

    public function show($id)
    {
        $log = $this->service->getById($id);
        if (!$log) {
            return response()->json(['error' => 'Log not found'], 404);
        }
        return response()->json($log);
    }

    public function store(Request $request)
    {
        $log = $this->service->create($request->all());
        return response()->json($log, 201);
    }
}
