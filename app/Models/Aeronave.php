<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeronave extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    // Overrides primary key
    protected $primaryKey = 'matricula';
    // Disables auto increment primary key
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matricula','marca','modelo','num_lugares','conta_horas','preco_hora'
    ];

    protected $dates = ['deleted_at'];

    public function aeronaves_pilotos(){
        return $this->belongsToMany('App\User','aeronaves_pilotos','piloto_id');
    }

    public function aeronave_movimentos(){
        return $this->hasMany('App\Movimento','aeronave','matricula');
    }

}
