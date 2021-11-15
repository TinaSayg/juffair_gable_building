<?php

namespace App\Models;
use App\Models\NoticeBoardStatus;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;
    protected $fillable = [
        'notice_text',
        'notice_date',
        'role_id',
        'notice_board_status_code',
        
    ];
    public function notice_status(){
        return $this->belongsTo(NoticeBoardStatus::class, 'notice_board_status_code', 'notice_boardstatus_code');
    }
    public function role(){
        return $this->belongsTo(Role::class, 'role_id','id');
    }
}
