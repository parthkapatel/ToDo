<?php

namespace App\Repository;

use App\Interfaces\ToDoRepositoryInterface;
use App\Models\ToDo;

class ToDoRepository implements ToDoRepositoryInterface
{
    private $todo;

    /**
     * ToDoRepository constructor.
     * @param ToDo $toDo
     */
    public function __construct(ToDo $toDo)
    {
        $this->todo = $toDo;
    }

    public function all()
    {
        return $this->todo->orderBy('task_order')->orderBy('mark_as_favorite', 'DESC')->get();
    }

    public function save($data)
    {
        $order = $this->todo::max("task_order");
        $this->todo->title = $data["title"];
        $this->todo->start_date = $data["start_date"];
        $this->todo->due_date = $data["due_date"];
        $this->todo->notes = $data["notes"];
        $this->todo->task_order = $order + 1;
        $this->todo->save();
        return $this->todo;
    }

    public function getDataById($task_id)
    {
        return $this->todo->where("id",$task_id)->get()[0];
    }

    public function update($data, $task_id)
    {
        $this->todo = $this->todo::find($task_id);
        $this->todo->title = $data["title"];
        $this->todo->start_date = $data["start_date"];
        $this->todo->due_date = $data["due_date"];
        $this->todo->notes = $data["notes"];
        $this->todo->save();
        return $this->todo;
    }

    public function delete($task_id)
    {
        return $this->todo::find($task_id)->delete();
    }

    public function updateTaskOrder($ids)
    {
        for($i = 0;$i < count($ids); $i++){
            $this->todo = $this->todo::find($ids[$i]);
            $this->todo->task_order = $i+1;
            $this->todo->save();
        }
        return $this->todo;
    }

    public function updateMarkAsRead($task_id)
    {
        $this->todo = $this->todo::find($task_id);
        if ($this->todo->mark_as_read == 1)
            $this->todo->mark_as_read = 0;
        else
            $this->todo->mark_as_read = 1;
        $this->todo->save();
        return $this->todo;
    }

    public function updateMarkAsFavorite($task_id)
    {
        $this->todo = $this->todo::find($task_id);
        if ($this->todo->mark_as_favorite == 1)
            $this->todo->mark_as_favorite = 0;
        else
            $this->todo->mark_as_favorite = 1;
        $this->todo->save();
        return $this->todo;

    }

    public function searchDataByString($str)
    {
        if($str == "")
            return $this->all();
        return $this->todo::where('title', 'LIKE', "%{$str}%")->orWhere('notes', 'LIKE', "%{$str}%")->get();
    }
}
