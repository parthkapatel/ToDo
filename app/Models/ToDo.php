<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;
    protected $fillable = [
        "title"
    ];
    /**
     * @var mixed
     */
    private $title;
    /**
     * @var mixed
     */
    private $start_date;
    /**
     * @var mixed
     */
    private $due_date;
    /**
     * @var mixed
     */
    private $notes;
    /**
     * @var int|mixed
     */
    private $task_order;
}
