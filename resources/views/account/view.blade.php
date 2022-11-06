@extends('layouts.main')
@section('title',$account->name)
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
                    <div class="card">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
