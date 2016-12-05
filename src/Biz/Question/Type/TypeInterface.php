<?php
namespace Biz\Question\Type;

interface TypeInterface
{
    public function create($fields);

    public function update($id, $fields);

    public function delete($id);

    public function get($id);

    public function filter($fields);
}
