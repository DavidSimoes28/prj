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
    <label for="tipo_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Tipo Licença') }}</label>
    <div class="col-md-6">
        <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('tipo_licenca') ? ' is-invalid' : '' }}"  name="tipo_licenca">                   
            @foreach ($licencas as $tipo)
                <option value ="{{$tipo->code}}" {{ strval(old('tipo_licenca',$tipo->code)) == $user->tipo_licenca ?"selected":"" }}>{{ $tipo->code }} </option>
            @endforeach
        </select>
        @if ($errors->has('tipo_licenca'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('tipo_licenca') }}</strong>
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
        <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('classe_certificado') ? ' is-invalid' : '' }}"  name="classe_certificado" >                   
            @foreach ($certificados as $classe)
                <option value ="{{$classe->code}}" {{ strval(old('classe_certificado',$classe->code)) == $user->classe_certificado ?"selected":"" }}>{{ $classe->code }} </option>
            @endforeach
        </select>
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
    <label for="instrutor" class="col-md-4 col-form-label text-md-right">{{ __('Instrutor') }}</label>
    <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="0" {{ intval(old('instrutor',$user->instrutor)) == 0?"checked":"" }}> Não <br>
        <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="1" {{ intval(old('instrutor',$user->instrutor)) == 1?"checked":"" }}> Sim <br>
        @if ($errors->has('instrutor'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('instrutor') }}</strong>
            </span>
        @endif
    </div>
</div>
