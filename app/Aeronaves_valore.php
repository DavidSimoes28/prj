<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeronaves_valore extends Model
{
    public $timestamps = false;

    protected $fillable = ['minutos', 'preco','unidade_conta_horas','matricula'];
}
