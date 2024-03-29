@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Painel')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $access }}</h3>
                <p>Visitas</p>
            </div>
            <div class="icon">
                <i class="far fa-fw fa-eye"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $userOnline }}</h3>
                <p>Usuários online</p>
            </div>
            <div class="icon">
                <i class="far fa-fw fa-heart"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pages }}</h3>
                <p>Páginas</p>
            </div>
            <div class="icon">
                <i class="far fa-fw fa-sticky-note"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $users }}</h3>
                <p>Usuários</p>
            </div>
            <div class="icon">
                <i class="far fa-fw fa-user"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Páginas mais visitadas
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Sobre o sistema
                </div>
                <div class="card-body">
                    ...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {

        ctx = document.getElementById('pagePie').getContext('2d');
        window.pagePie = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: {{ $pageValues }},
                    backgroundColor: '#0000FF'
                }],
                labels: {!! $pageLabels !!}
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                }
            }
        })
    }
</script>

@endsection