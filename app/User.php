<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_socio','name','nome_informal','password','tipo_socio', 'email','sexo','data_nascimento','nif','telefone','foto_url','endereco',
        'num_licenca','tipo_licenca','instrutor','validade_licenca','licenca_confirmada','num_certificado',
        'classe_certificado','validade_certificado','certificado_confirmado','certificado_pdf','licenca_pdf','ativo','quota_paga',
        'direcao'
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

    protected $dates = ['deleted_at'];

    public function movimentos_instrutor()
    {
        return $this->hasMany('App\Movimento','intrutor_id');
    }

    public function movimentos_piloto()
    {
        return $this->hasMany('App\Movimento','piloto_id');
    } 


    public function isDirecaoToStr()
    {
        switch ($this->direcao) {
            case 0:
                return 'Não';
            case 1:
                return 'Sim';
 
        }
        return 'Unknown';
    }

    public function isAtivoToStr()
    {
        switch ($this->ativo) {
            case 0:
                return 'Não';
            case 1:
                return 'Sim';
 
        }
        return 'Unknown';
    }

    public function isQuotaPagaToStr()
    {
        switch ($this->quota_paga) {
            case 0:
                return 'Não Paga';
            case 1:
                return 'Paga';
 
        }
        return 'Unknown';
    }

    public function tipoSocioToStr()
    {
        switch ($this->tipo_socio) {
            case "P":
                return 'Piloto';
            case "NP":
                return 'Não Piloto';
            case "A":
                return 'Aeromodelista';
 
        }
        return 'Unknown';
    }

    public function sexoToStr()
    {
        switch ($this->sexo) {
            case "M":
                return 'Masculino';
            case "F":
                return 'Feminino';
 
        }
        return 'Unknown';
    }

    public function isAdmin(){
        return $this->direcao==1;
    }

    public function isPiloto(){
        return $this->tipo_socio=="P";
    }

    public function isInstrutor(){

        if($this->isPiloto()) return $this->instrutor;
    
        return 0;
    }

    public function certificadoConfirmardoToStr()
    {
        switch ($this->certificado_confirmado) {
            case "1":
                return 'Confirmado';
            case "0":
                return 'Não confirmado';
        }
        return 'Unknown';
    }

    public function licencaConfirmardaToStr()
    {
        switch ($this->licenca_confirmada) {
            case "1":
                return 'Confirmada';
            case "0":
                return 'Não confirmada';
        }
        return 'Unknown';
    }

    


    public function isAtivo(){
        return $this->ativo==1;
    }

    public function isQuotaPaga(){
        return $this->quota_paga==1;
    }

    public function hasLicenca(){
        //return Storage::exists(storage_path('app/docs_piloto/' . 'licenca_' . $this->id . '.pdf'));
        //return Storage::disk("local")->exists('app/docs_piloto/' . 'licenca_' . $this->id . '.pdf');
        $path = storage_path('app/docs_piloto/' . 'licenca_' . $this->id . '.pdf');

        if(!Storage::exists($path)){
            return true;
        }

        return false;

        
    }

    public function hasCertificado(){
        //return Storage::exists(storage_path('app/docs_piloto/' . 'certificado_' . $this->id . '.pdf'));
        //return Storage::disk("local")->exists('app/docs_piloto/' . 'certificado_' . $this->id . '.pdf');

        $path = storage_path('app/docs_piloto/' . 'certificado_' . $this->id . '.pdf');

        if(!Storage::exists($path)){
            return true;
        }

        return false;
    }
}
