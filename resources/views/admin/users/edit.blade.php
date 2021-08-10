@extends('adminlte::page')

@section('title', 'Novo Usuário')

@section('content_header')
    <h1>Editar usuário</h1>
@endsection

@section('content')

    @if($errors->any())
        @if(count($errors) == 1)
            <h4>Ocorreu um erro.</h4>
        @elseif(count($errors) > 1)
            <h4>Ocorreram erros.</h4>
        @endif
        <ul>
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <li>{{ $error }}</li>       
                </div>
            @endforeach
        </ul>
    @endif

    <form class="form-orizontal" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label col-sm-2">Nome Completo</label>
            <input type="text" class="form-control col-sm-10 @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-group row">
            <label for="email" class="col-form-label col-sm-2">Email</label>
            <input type="email" class="form-control col-sm-10 @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}">
        </div>

        <div class="form-group row">
            <label for="password" class="col-form-label col-sm-2">Nova Senha</label>
            <input type="password" class="form-control col-sm-10 @error('password') is-invalid @enderror" name="password">
        </div>

        <div class="form-group row">
            <label for="password_confirmation" class="col-form-label col-sm-2">Confirme a senha</label>
            <input type="password" class="form-control col-sm-10 @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
        </div>

        <div class="form-group row">
            <label for="" class="col-form-label col-sm-2"></label>
            <div class="col-sm-10">
                <input type="submit" class="btn btn-md btn-success" value="Editar Usuário">
            </div>
        </div>
    </form>
@endsection