@extends('adminlte::page')

@section('title', 'Novo Usuário')

@section('content_header')
    <h1>Novo usuário</h1>
@endsection

@section('content')
    <form class="form-orizontal" action="{{ route('users.store') }}" method="POST">
        <div class="form-group">
            <div class="row">
                <label for="name" class="control-label col-sm-2">Nome Completo</label>
                <input type="text" class="form-control col-sm-10" name="name">
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="email" class="control-label col-sm-2">Email</label>
                <input type="email" class="form-control col-sm-10" name="email">
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="password" class="control-label col-sm-2">Senha</label>
                <input type="password" class="form-control col-sm-10" name="password">
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="password_confirmation" class="control-label col-sm-2">Confirme a senha</label>
                <input type="password" class="form-control col-sm-10" name="password_confirmation">
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="" class="control-label col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-md btn-success" value="Criar Usuário">
                </div>
            </div>
        </div>
    </form>
@endsection