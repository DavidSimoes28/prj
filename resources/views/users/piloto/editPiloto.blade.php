<div class="form-group row">
    <label for="num_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Nº Licença') }}</label>

    <div class="col-md-6">
        <input id="num_licenca" type="text" class="form-control{{ $errors->has('num_licenca') ? ' is-invalid' : '' }}" name="num_licenca" value="{{ $user->num_licenca }}" autofocus>

        @if ($errors->has('num_licenca'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('num_licenca') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="file_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Cópia da Licença') }}</label>

    <div class="col-md-6">
        <input type="file" id="file_licenca" name="file_licenca">
        @if ($errors->has('file_licenca'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('file_licenca') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="tipo_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Licença') }}</label>
    <div class="col-md-6">
        <input id="tipo_licenca" type="text" class="form-control{{ $errors->has('tipo_licenca') ? ' is-invalid' : '' }}" name="tipo_licenca" value="{{ $user->tipo_licenca }}" autofocus>
        @if ($errors->has('tipo_licenca'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('tipo_licenca') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="instrutor" class="col-md-4 col-form-label text-md-right">{{ __('Instrutor') }}</label>
    <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="0" {{ strval(old('instrutor',$user->instrutor)) == "0"?"checked":"" }} disabled> Não <br>
        <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="1" {{ strval(old('instrutor',$user->instrutor)) == "1"?"checked":"" }} disabled> Sim <br>
        @if ($errors->has('instrutor'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('instrutor') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="validade_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Validade') }}</label>

    <div class="col-md-6">
        <input id="validade_licenca" type="date" class="form-control{{ $errors->has('validade_licenca') ? ' is-invalid' : '' }}" name="validade_licenca" value="{{ $user->validade_licenca }}" autofocus>

        @if ($errors->has('validade_licenca'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('validade_licenca') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="licenca_confirmada" class="col-md-4 col-form-label text-md-right">{{ __('Confirmado') }}</label>
    <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('licenca_confirmada') ? ' is-invalid' : '' }}" name="licenca_confirmada" value="0" {{ strval(old('licenca_confirmada',$user->licenca_confirmada)) == "0"?"checked":"" }} disabled> Não <br>
        <input type="radio" class="form{{ $errors->has('licenca_confirmada') ? ' is-invalid' : '' }}" name="licenca_confirmada" value="1" {{ strval(old('licenca_confirmada',$user->licenca_confirmada)) == "1"?"checked":"" }} disabled> Sim <br>
        @if ($errors->has('licenca_confirmada'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('licenca_confirmada') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group row">
    <label for="num_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Nº Certificado') }}</label>

    <div class="col-md-6">
        <input id="num_certificado" type="text" class="form-control{{ $errors->has('num_certificado') ? ' is-invalid' : '' }}" name="num_certificado" value="{{ $user->num_certificado }}" autofocus>

        @if ($errors->has('num_certificado'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('num_certificado') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="file_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Cópia de Certificado') }}</label>

    <div class="col-md-6">
        <input type="file" id="file_certificado" name="file_certificado">
        @if ($errors->has('file_certificado'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('file_certificado') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="classe_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Classe de Certificado') }}</label>
    <div class="col-md-6">
    <input id="classe_certificado" type="text" class="form-control{{ $errors->has('classe_certificado') ? ' is-invalid' : '' }}" name="classe_certificado" value="{{ $user->classe_certificado }}" autofocus>
 @if ($errors->has('classe_certificado'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('classe_certificado') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="validade_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Validade') }}</label>

    <div class="col-md-6">
        <input id="validade_certificado" type="date" class="form-control{{ $errors->has('validade_certificado') ? ' is-invalid' : '' }}" name="validade_certificado" value="{{ $user->validade_certificado }}" autofocus>

        @if ($errors->has('validade_certificado'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('validade_certificado') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="certificado_confirmado" class="col-md-4 col-form-label text-md-right">{{ __('Confirmado') }}</label>
    <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('certificado_confirmado') ? ' is-invalid' : '' }}" name="certificado_confirmado" value="0" {{ strval(old('certificado_confirmado',$user->certificado_confirmado)) == "0"?"checked":"" }} disabled> Não <br>
        <input type="radio" class="form{{ $errors->has('certificado_confirmado') ? ' is-invalid' : '' }}" name="certificado_confirmado" value="1" {{ strval(old('certificado_confirmado',$user->certificado_confirmado)) == "1"?"checked":"" }} disabled> Sim <br>
        @if ($errors->has('certificado_confirmado'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('certificado_confirmado') }}</strong>
            </span>
        @endif
    </div>
</div>