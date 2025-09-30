<?php

namespace App\Repositories;

use App\Models\Node;
use MongoDB\Laravel\Eloquent\Casts\ObjectId;

class NodeRepository
{
    public function all()
    {
        return Node::all();
    }

    public function find($id)
    {
        return Node::find($id);
    }

    public function create(array $data)
    {
        return Node::create($data);
    }

    public function update(Node $node, array $data)
    {
        $node->update($data);
        return $node;
    }

    public function delete(Node $node)
    {
        return $node->delete();
    }

    public function findByFields(array $conditions)
    {
        $query = Node::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        $query->where('status', 'public');
        return $query->get();
    }
}