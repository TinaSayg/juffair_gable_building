<?php

namespace App\Models;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public function task_status(){
        return $this->belongsTo(TaskStatus::class, 'task_status_code', 'task_status_code');
    }

    public function assignee(){
        return $this->belongsTo(User::class, 'assignee_id', 'id');
    }
}
