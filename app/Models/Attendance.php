<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'trainor_id',
        'date',
        'status',
        'time',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainor()
    {
        return $this->belongsTo(Trainor::class);
    }
}
