@extends('layouts.app')

@section('content')
    <section class="novedades-section">
        <div class="container programa-container-principal" style="width: 526px;height: 75vh;">
            
            <div class="container row" style="padding-left: 0px;padding-right: 0px;margin-left: 0px;margin-right: 0px;">
                <div class="container" style="margin-top: 5rem;">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                                <div class="card-header">Backoffice Login</div>

                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="row mb-3">
                                            <div class="titulo">
                                            <label for="email"
                                                class="">Correo Electrónico</label>
                                            </div>
                                            <div class="campo">
                                           
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror home-contact-back-input" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                          
                                        </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="titulo">
                                            <label for="password"
                                                class="">Contraseña</label>
                                            </div>
                                            <div class="campo">
                                           
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror home-contact-back-input"
                                                    name="password" required autocomplete="current-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                          
                                            </div>
                                        </div>
                                       
                                        <div class="row mb-0 boton">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                   Acceder
                                                </button>

                                            </div>
                                        </div>
                                   
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
.card-header{ 
    background-color: #37BBED !important;
    color: white;
    font-size: 16px;
    font-weight: 700;
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
}

.card-body {
    background-color: white;
    border-bottom-left-radius: 10px !important;
    border-bottom-right-radius: 10px !important;    
    padding-top: 2rem !important;
}

.titulo{
    display: flex !important;
    justify-content: start !important;
}
.novedades-section {
    background-color: #E5E5E5;
    /*padding: 3rem; */
    height: 660px;
    padding-left: 430px;
    padding-right: 430px;
    padding-top: 60px;
    padding-bottom: 73px;
    margin-top: 49px;
  }

  .btn-primary{
    width: 150px;
    background-color: #37BBED !important;
    border: 1px solid #37BBED !important;
  }

  .btn-primary:hover{
    background-color: white !important;
    color: #37BBED !important;
  }

  .boton{
    margin-top: 50px !important;
  }

  .home-contact-back-input {
    background-color: rgba(55, 187, 237, 0.2) !important;
    height: 56px;
  }

  .home-contact-back-input:focus::placeholder {
    color: transparent;
  }
</style>
