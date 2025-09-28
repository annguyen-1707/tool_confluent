<?php

namespace App\Repositories;

use App\Models\Node;

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
}
