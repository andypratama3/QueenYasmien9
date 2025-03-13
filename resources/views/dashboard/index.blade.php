@extends('layouts.dashboard')

@section('title', 'Kategori')

@section('content')
<h1 class="h3 mb-3"><strong>Analistik</strong> Dashboard</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pengunjung</h5>
                <select id="dataRange" class="form-select w-auto">
                    <option value="day">Harian</option>
                    <option value="month" selected>Bulanan</option>
                    <option value="year">Tahunan</option>
                </select>
            </div>
            <div class="card-body d-flex w-100">
                <div class="align-self-center chart chart-lg">
                    <canvas id="chartjs-dashboard-bar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
