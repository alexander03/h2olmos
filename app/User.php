<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopegetFilter($query, $estado, $filter) {
        return $query->where(function($subquery) use ($estado) {
                if($estado === 'activos') $subquery->whereNull('users.deleted_at');
                elseif($estado === 'desactivados') $subquery->whereNotNull('users.deleted_at');
            })
            ->where(function($subquery) use ($filter) {
                $subquery->where('users.username', strtoupper($filter))
                    ->orWhere('users.name', 'LIKE', '%'.strtoupper($filter).'%');
            })
            ->orderBy('users.name', 'ASC')->withTrashed()
            ->select('users.name', 'users.username');
    }
}
