@extends('layouts.main')
@section('title','Bank Accounts')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-chart-area bg-c-green"></i>
                    <div class="d-inline">
                        <h5>Bank Accounts</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Bank Accounts</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addJournal">
                                Add Bank Account
                            </button>
                            <button class="btn btn-outline-dark btn-round" data-toggle="modal" data-target="#addJournal">
                                Transaction Records
                            </button>
                            <button class="btn btn-outline-warning btn-round" data-toggle="modal" data-target="#addJournal">
                                Download Cashbook
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
