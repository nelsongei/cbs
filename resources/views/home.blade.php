@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h5></h5>
                        <span>Dashboard</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #6dd144">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Members</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users f-18" style="color: #6dd144"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10" style="">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #644ec5">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Loans</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-copy f-18" style="color: #644ec5"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-primary">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Dividends</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-print text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #ff8d34">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Users</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user f-18" style="color: #ff8d34"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-body" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-body" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
