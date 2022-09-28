<?php

namespace App\Models;

use App\Models\Scopes\JobPositionPublishScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_name',
        'position_description',
        'is_published'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new JobPositionPublishScope());
    }

    public function details()
    {
        return $this->hasMany(JobPositionDetail::class);
    }
}
