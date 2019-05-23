<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('<!-- app.name --> FlightClub ', 'FlightClub') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('<!-- app.name --> FlightClub ', 'FlightClub') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <a class="nav-link" href="{{ route('socios') }}">{{ __('Sócios') }}</a>
                        <a class="nav-link" href="{{ route('aeronaves') }}">{{ __('Aeronaves') }}</a>
                        <a class="nav-link" href="{{ route('movimentos') }}">{{ __('Movimentos') }}</a>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="  "></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        
                                        <a href="#response" class="dropdown-item" data-toggle="modal" data-target="#response">
                                        {{ __('Perfil') }}
                                        </a>
                                        
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                    
                                            {{ __('Logout') }}
                                        </a>
                                        

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                        </form>

                                        <li>
                                        </li>

                                        <!--
                                        -->
                                        

                                        <div class="modal" id="response">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="list-group">
                                                            <div class="d-flex w-100 justify-content-between">

                                                                <div class="container">
                                                                    <div class="row justify-content-center">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr><h4>Dados Pessoais</h4></tr>                                                                          
                                                                        </thead>
                                                                        <div class="card-body ">
                                                                            
                                                                                <tr>
                                                                                    <td><span class="input-group-text">Nº Sócio: {{ Auth::user()->num_socio }}</span></td>
                                                                                    <td><span class="input-group-text">Nome: {{ Auth::user()->name }}</span></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td><span class="input-group-text">Telefone: {{ Auth::user()->telefone }}</span></td>
                                                                                    <td><span class="input-group-text">Nome Informal: {{ Auth::user()->nome_informal }}</span></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td><span class="input-group-text">Sexo: {{ Auth::user()->sexoToStr() }}</span></td>
                                                                                    <td><span class="input-group-text">Data de nascimento: {{ Auth::user()->data_nascimento }}</span></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td><span class="input-group-text">E-mail: {{ Auth::user()->email }}</span></td>
                                                                                    <td><span class="input-group-text">Tipo de sócio: {{ Auth::user()->tipoSocioToStr() }}</span></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td><span class="input-group-text">NIF: {{ Auth::user()->nif }}</span></td>
                                                                                    <td><span class="input-group-text">Direção: {{ Auth::user()->isDirecaoToStr() }}</span></td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td><span class="input-group-text">Quota: {{ Auth::user()->isQuotaPagaToStr() }}</span></td>
                                                                                    <td><span class="input-group-text">Ativo: {{ Auth::user()->isAtivoToStr() }}</span></td>
                                                                                    
                                                                                </tr>


                                                                            </table>
                                            
                                                                        </div>
                                                                

                                                                        @if(Auth::user()->isPiloto())
                                                                        <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>                                                                                
                                                                                <td style="width: 35%"><h4>Licença</h4></td>
                                                                                <td style="width: 40%">
                                                                                    <h5 class="d-inline">
                                                                                    @if(Auth::user()->hasLicenca())
                                                                                    <a href="{{ route('pilotos.licenca',['id'=>Auth::user()->id]) }}" title="Licenca" target="_blank"> Cópia Digital</a>
                                                                                    @else
                                                                                    Não possui Cópia Digital
                                                                                    @endif
                                                                                    </h5>
                                                                                </td>
                                                                                <td>{{ Auth::user()->licencaConfirmardaToStr() }}</td>
                                                                            </tr>                                                                       
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Nº Licença: {{ Auth::user()->num_licenca }}</td>
                                                                                <td>Tipo de Licença: {{ Auth::user()->tipo_licenca }}</td>
                                                                                <td>Válida até {{ Auth::user()->validade_licenca }}</td> 
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Instrutor: {{ Auth::user()->instrutor }}</td>
                                                                            </tr>
                                                                        </table>

                                                                        <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <td style="width: 35%"><h4 class="d-inline">Certificado</h4></td>
                                                                                <td style="width: 40%">
                                                                                    <h5 class="d-inline">
                                                                                    @if(Auth::user()->hasCertificado())
                                                                                    <a href="{{ route('pilotos.certificado',['id'=>Auth::user()->id]) }}" title="Certificado" target="_blank"> Cópia Digital</a>
                                                                                    @else
                                                                                    Não possui Cópia Digital
                                                                                    @endif
                                                                                    </h5>
                                                                                </td>
                                                                                <td>{{ Auth::user()->certificadoConfirmardoToStr() }}</td>
                                                                            </tr>                                                                          
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Nº Certificado: {{ Auth::user()->num_certificado }}</td>
                                                                                <td>Classe: {{ Auth::user()->classe_certificado }}</td>
                                                                                <td>Válido até {{ Auth::user()->validade_certificado }}</td>
                                                                                
                                                                            </tr>
                                                                        </table>
                                                                        @endif
                                                            
                                                            
                                                                    </div>
                                                        
                                                                </div>
                                                        </div>
                                                    
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class = "btn-group">
                                                            <a class="btn btn-xs btn-primary" href="{{ route('socios.edit', ['id'=> Auth::user()->id]) }}">{{ __('Alterar Perfil') }}</a>
                                                            <a class="btn btn-xs btn-dark" href="{{ route('password.showPass', ['id'=> Auth::user()->id]) }}">{{ __('Alterar Password') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <!--
                                        -->
                                        

                                        
                                    

                                    
                                        
                                        
                                </div>
                                
                                        
                                       
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>



