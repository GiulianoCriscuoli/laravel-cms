@extends('adminlte::page')

@section('title', 'Editar Página')

@section('content_header')
    <h1>Editar Página</h1>
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

    <form class="form-orizontal" action="{{ route('pages.update', ['page' => $page->id]) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="title" class="col-form-label col-sm-2">Título</label>
            <input type="text" class="form-control col-sm-10 @error('title') is-invalid @enderror" name="title" value="{{ $page->title }}">
        </div>

        <div class="form-group row">
            <label for="body" class="col-form-label col-sm-2">Conteúdo</label>
            <textarea class="form-control bodyfield col-sm-10 @error('body') is-invalid @enderror" name="body">{{ $page->body }}</textarea>
        </div>

        <div class="form-group row">
            <label for="" class="col-form-label col-sm-2"></label>
            <div class="col-sm-10">
                <input type="submit" class="btn btn-md btn-success" value="Editar Usuário">
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
            toolbar: 'undo redo | link image | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | paragraph'
        });
        
    </script>
@endsection