<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPositionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'job_position_id',
        'order'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
