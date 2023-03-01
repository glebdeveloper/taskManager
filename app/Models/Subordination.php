<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subordination extends Model
{
    protected $fillable = ['subordinate_id', 'boss_id'];

    public function subordinate()
    {
        return $this->belongsTo(User::class, 'subordinate_id');
    }

    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id');
    }
}
