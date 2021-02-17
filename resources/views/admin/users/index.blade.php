@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Lista de Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Adicionar um novo usuário</a>    
    </div>
@endsection

@section('content')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>    

        @foreach ($users as $user)
            <tbody>
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                        <a href="{{ route('users.destroy', ['user' => $user->id]) }}" class="btn btn-sm btn-danger">Excluir</a>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table> 
    
    {{ $users->links() }}
@endsection