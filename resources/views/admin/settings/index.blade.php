@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>
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

@else 
    @if(session('success'))
        <div class="alert alert-success">
            {{  session('success') }}
        </div>
    @endif
@endif

<form class="form-orizontal" action="{{ route('settings.save') }}" method="POST">
    @csrf
    @method('PUT')
<div class="form-group row">
    <label for="name" class="col-form-label col-sm-2">Título</label>
    <input type="text" class="form-control col-sm-10 @error('name') is-invalid @enderror" name="name">
</div>
<div class="form-group row">
    <label for="content" class="col-form-label col-sm-2">Conteúdo</label>
    <textarea class="form-control col-sm-10 @error('content') is-invalid @enderror" name="content"></textarea>
</div>
<div class="form-group row">
    <label for="bgText" class="col-form-label col-sm-2">Cor de texto</label>
    <input type="color" class="form-control col-sm-10 @error('bgText') is-invalid @enderror" name="bgText">
</div>
<div class="form-group row">
    <label for="bgColor" class="col-form-label col-sm-2">cor de fundo</label>
    <input type="color" class="form-control col-sm-10 @error('bgColor') is-invalid @enderror" name="bgColor">
</div>

<div class="form-group row">
    <label for="" class="col-form-label col-sm-2"></label>
    <div class="col-sm-10">
        <input type="submit" class="btn btn-md btn-success" value="Editar Perfil">
    </div>
</div>
</form>

@endsection