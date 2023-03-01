<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'must_ended_at',
        'priority_id',
        'status_id',
        'creator_id',
        'responsible_id',
        'mode_id',
    ];

    protected $dates = ['must_ended_at'];

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}