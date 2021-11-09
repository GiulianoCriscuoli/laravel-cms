@extends('adminlte::page')

@section('title', 'Páginas')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Lista de Páginas</h1>
        <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">Adicionar uma nova página</a>    
    </div>
@endsection

@section('content')

    @if(session('success'))
       <div class="alert alert-success">{{ session('success') }}</div> 
    @endif
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>slug</th>
                <th>Ações</th>
            </tr>
        </thead>
        
        @if(isset($pages))
            @foreach ($pages as $page)
                <tbody>
                    <tr>
                        <td>{{ $loop->index + 1}}</td>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>
                            <a href="{{ route('pages.edit', ['page' => $page->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                        
                            <form class="d-inline-flex" action="{{ route('pages.destroy', ['page' => $page->id]) }}" onsubmit="return confirm('Certeza que deseja excluir?')" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        @endif
    </table>
    {{ $pages->links() }}
@endsection