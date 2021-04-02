<?php

namespace App\Interfaces;

use App\Models\ToDo;
use Illuminate\Support\Collection;

interface ToDoRepositoryInterface
{
    public function all();

    public function save($data);

    public function getDataById($task_id);

    public function update($data,$task_id);

    public function delete($task_id);

    public function updateTaskOrder($ids);

    public function updateMarkAsRead($task_id);

    public function updateMarkAsFavorite($task_id);

    public function searchDataByString($str);

}
