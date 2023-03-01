<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Task;
use App\Models\Subordination;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'middle_name',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
    }
    
    public function tasks_count()
    {
        return $this->hasMany(Task::class, 'creator_id')
        ->selectRaw('creator_id, status_id, count(*) as count')
        ->groupBy('creator_id', 'status_id');
    }
    
    
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'responsible_id');
    }
    public function doneTasks(){
        return $this->createdTasks()->where('status_id', 3);
    }
    
    public function inProgressTasks()
    {
    return $this->createdTasks()->where('status_id', 2);
        
    }
    public function canceledTasks()
    {
    return $this->createdTasks()->where('status_id', 4);
        
    }
    public function toDoTasks()
    {
    return $this->createdTasks()->where('status_id', 1);
        
    }
    

    public function subordinates()
    {
        return $this->hasMany(Subordination::class, 'boss_id');
    }

    public function isBoss()
    {
        return $this->role_id === 1;
    }

    public function isSubordinate()
    {
        return $this->role_id === 2;
    }
    public function isRoot()
    {
        return $this->role_id === 3;
    }
}
