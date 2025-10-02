<?php

namespace App\Services;

use App\Enums\Role;
use App\Enums\Status;
use App\Enums\Disable;
use App\Repositories\LogRepository;
use App\Repositories\NodeRepository;
use Illuminate\Support\Facades\Auth;

class NodeService
{
    protected $repo;
    protected $repoLog;

    public function __construct(NodeRepository $repo, LogRepository $repoLog)
    {
        $this->repo = $repo;
        $this->repoLog = $repoLog;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        $data['title'] = $data['title'] ?? null;
        $data['project_id'] = $data['project_id'];
        $data['description'] = $data['description'] ?? null;
        $data['created_by'] = Auth::id();
        $data['status'] = Status::Pending->value;
        $data['disable'] = Disable::Processing->toBool();
        $node = $this->repo->create($data);

        $this->repoLog->create([
            'title'       => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'project_id' => $node->project_id,
            'node_id'    => $node->_id,
            'action'     => 'Create',
            'type'       => 'node',
            'old_value'  => null,
            'new_value'  => $data,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
        return $node;
    }

    public function update($id, array $data)
    {
        $oldNode = $this->repo->find($id);
        if (!$oldNode) return null;
        $newNode =  $this->repo->update($oldNode, $data);
        $this->repoLog->create([
            'title' => 'Cập nhật mốc thời gian thành công',
            'project_id' => $newNode->project_id,
            'type' => 'Node',
            'action' => 'Update',
            'old_value' => $oldNode,
            'new_value' => $newNode,
            'created_by' => Auth::id(),
            'target_id' => $newNode->id,
        ]);
        return $newNode;
    }

    public function delete($id)
    {
        $node = $this->repo->find($id);
        if (!$node) return false;

        return $this->repo->delete($node);
    }

    public function deleteSoft($id)
    {
        $node = $this->repo->find($id);
        if (!$node) return false;
        $node->status = Status::Deleted->value;
        $node->save();
        $this->repoLog->create([
            'title' => 'Cập nhật mốc thời gian thành công',
            'project_id' => $node->project_id,
            'type' => 'Node',
            'action' => 'Update',
            'old_value' => $node,
            'new_value' => null,
            'created_by' => Auth::id(),
            'target_id' => $node->id,
        ]);
        return true;
    }

    public function findByFields(array $conditions)
    {
        return $this->repo->findByFields($conditions);
    }
}
