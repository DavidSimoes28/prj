<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_socio','name','nome_informal','password','tipo_socio', 'email','sexo','data_nascimento','nif','telefone','foto_url','endereco',
        'num_licenca','tipo_licenca','instrutor','validade_licenca','licenca_confirmada','num_certificado',
        'classe_certificado','validade_certificado','certificado_confirmado','certificado_pdf','licenca_pdf'
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
}
