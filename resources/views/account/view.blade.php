@extends('layouts.main')
@section('title',$account->name.' --- '.$account->code)
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-plus-circle bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>{{$account->name.' '.$account->code}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('account/chart')}}">Accounts</a></li>
                        <li class="breadcrumb-item active"><a href="#">Chart of Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img class="img-fluid img-rounded img-circle img-150"
                                    src="{{asset('images/giphy.gif')}}" alt="img">
                                    <h4 class="text-c-blue mt-2">{{$account->name}}</h4>
                                    <h4 class="text-c-green mt-2">{{$account->category->name}}</h4>
                                    <h4 class="text-success mt-2">{{$account->code}}</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <strong class="text-c-orenge">
                                        <i class="fa fa-check-circle mr-1"></i>Account Balance
                                    </strong>
                                    <p class="text-muted">
                                        0.0
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ref. No</th>
                                                <th>Description</th>
                                                <th>Payment</th>
                                                <th>Deposit</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
