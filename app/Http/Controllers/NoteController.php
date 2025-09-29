<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Services\NoteService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Note;
use Illuminate\Validation\Rules\Enum;

class NoteController extends Controller
{
    protected $service;

    public function __construct(NoteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        $note = $this->service->getById($id);
        if (!$note) return response()->json(['error' => 'Not found'], 404);
        return response()->json($note);
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title'       => 'required|string|max:255',
        //     'start_date'  => 'nullable|date',
        //     'end_date'    => 'nullable|date|after_or_equal:start_date',
        //     'description' => 'nullable|string',
        //     'status'      => ['required', new Enum(Status::class)],
        //     'created_by'  => 'required|string',ßßß
        // ]);
        $note = $this->service->create($request->all());
        return response()->json($note, 201);
    }

    public function update(Request $request, $id)
    {
        $note = $this->service->update($id, $request->all());
        if (!$note) return response()->json(['error' => 'Not found'], 404);
        return response()->json($note);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) return response()->json(['error' => 'Not found'], 404);
        return response()->json(['message' => 'Deleted']);
    }
}
