<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        $user = $this->service->getById($id);
        if (!$user) return response()->json(['error' => 'Not found user'], 404);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $user = $this->service->create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = $this->service->update($id, $request->all());
        if (!$user) return response()->json(['error' => 'Not found user'], 404);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['error' => 'Not found user'], 404);
        return response()->json(['message' => 'Deleted']);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');              // từ khóa tìm kiếm
        $perPage = $request->input('per_page', 10);  // mặc định 10 item/trang

        $result = $this->service->search($keyword, $perPage);
        Log::info("Search request", [
            'keyword' => $keyword,   // log thêm dữ liệu
            'perPage' => $perPage
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
