<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Movimento extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','aeronave','data','hora_descolagem','hora_aterragem','natureza','piloto_id','aerodrome_partida','aerodromo_chegada','num_aterragens','num_descolagens',
        'num_diario','num_servico','conta_horas_inicio','conta_horas_fim','num_pessoas','tipo_instrucao','instrutor_id','confirmado','observacoes'
    ];
    
    public function pilotos(){
        return $this->belongsTo('App\User','piloto_id','id')->withTrashed();
    }

    public function instrutores(){
        return $this->belongsTo('App\User','instrutor_id','id')->withTrashed();
    }

    public function instrucaoConfirmadaToStr()
    {
        switch ($this->confirmado) {
            case 0:
                return 'Não';
            case 1:
                return 'Sim';
 
        }
        return 'Unknown';
    }

    public function naturezaToStr()
    {
        switch ($this->natureza) {
            case 'T':
                return 'Treino';
            case 'I':
                return 'Instrução';
            case 'E':
                return 'Especial';
 
        }
        return 'Unknown';
    }

    public function tipoInstrucaoToStr()
    {
        switch ($this->tipo_instrucao) {
            case "D":
                return 'Duplo Comando';
            case "S":
                return 'Solo';
 
        }
        return 'Unknown';
    }
}