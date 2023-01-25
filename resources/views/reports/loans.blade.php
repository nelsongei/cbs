@extends('layouts.main')
@section('title', 'Loan Reports')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-cpu bg-success"></i>
                    <div class="d-inline">
                        <h5>Loan Reports</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Loan Reports</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-round btn-outline-success">
                                        Export Report
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input type="text" class="form-control year"
                                                placeholder="Filter By Year"
                                                style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                style="height: 35px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="expenses" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanReleased" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanCollection" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body" style="justify-content: center;display: flex;">
                                            <canvas id="gender" height="250vw" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="fullyPaid" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('charts/loanreports.js') }}"></script>
@endsection
