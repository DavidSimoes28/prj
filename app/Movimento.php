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
        'id',
        'aeronave',
        'data',
        'hora_descolagem',
        'hora_aterragem',
        'natureza',
        'piloto_id',
        'aerodromo_partida',
        'aerodromo_chegada',
        'num_aterragens',
        'num_descolagens',
        'num_diario',
        'num_servico',
        'conta_horas_inicio',
        'conta_horas_fim',
        'num_pessoas',
        'tipo_instrucao',
        'instrutor_id',
        'confirmado',
        'observacoes',
        'num_licenca_piloto',
        'validade_licenca_piloto',
        'tipo_licenca_piloto',
        'num_certificado_piloto',
        'validade_certificado_piloto',
        'classe_certificado_piloto',
        'tempo_voo',
        'preco_voo',
        'modo_pagamento',
        'num_recibo',		
        'num_licenca_instrutor',
        'validade_licenca_instrutor',
        'tipo_licenca_instrutor',	
        'num_certificado_instrutor'	,
        'validade_certificado_instrutor',
        'classe_certificado_instrutor'
    ];		





    
    public function pilotos(){
        return $this->belongsTo('App\User','piloto_id','id')->withTrashed();
    }

    public function instrutores(){
        return $this->belongsTo('App\User','instrutor_id','id')->withTrashed();
    }

    public function aeronave_movimentos(){
        return $this->belongsTo('App\Models\Aeronave','aeronave','matricula');
    }

    public function instrucaoConfirmadaToStr()
    {
        switch ($this->confirmado) {
            case 0:
                return 'não confirmado';
            case 1:
                return 'confirmado';
 
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

    public function horaDePartida()
    {
        return date("H:i", strtotime($this->hora_descolagem));
    }

    public function horaDeChegada()
    {  
        return date("H:i", strtotime($this->hora_aterragem));
    }

    public function horasDeVoo()
    {  
        $format = '%02.0f:%02.0f';
        //echo sprintf($format, floor($this->tempo_voo / 60), ($this->tempo_voo -   floor($this->tempo_voo / 60) * 60);
        //$hora = floor($this->tempo_voo / 60).':'.($this->tempo_voo -   floor($this->tempo_voo / 60) * 60);
        return sprintf($format, floor($this->tempo_voo / 60), ($this->tempo_voo -   floor($this->tempo_voo / 60) * 60));
    }   

    public function isConfirmado(){
        return $this->confirmado==1;
    }

    public function pertencePiloto(User $user){////////////////////////////////////POR IMPLEMENTAR////////////////////
        if ($this->pilotos->id==$user->id) return true;
        if ($this->instrutores()->exists() && $this->instrutores->id==$user->id) return true;
        return false;
    }

}