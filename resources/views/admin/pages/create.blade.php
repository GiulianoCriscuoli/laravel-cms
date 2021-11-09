@extends('adminlte::page')

@section('title', 'Nova página')

@section('content_header')

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
            {{ session('success') }}
        </div>
    @endif

@endif

<form class="form-horizontal" action="{{ route('pages.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <label for="title" class="col-form-label col-sm-2">Título</label>
        <input type="text" class="form-control col-sm-10 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
    </div>

    <div class="form-group row">
        <label for="body" class="col-form-label col-sm-2">Conteúdo</label>
        <textarea class="form-control bodyfield col-sm-10 @error('body') is-invalid @enderror" name="body" value="{{ old('body') }}"></textarea>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            <input type="submit" class="btn btn-md btn-success" value="Criar Usuário">
        </div>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>

    tinymce.init({
        selector:'textarea.bodyfield',
        height:300,
        menubar:false,
        plugins:['link', 'table', 'lists', 'autoresizes'],
        toolbar: 'link image'
    });
    
</script>

@endsection

