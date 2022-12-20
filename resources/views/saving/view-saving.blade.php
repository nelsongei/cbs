@extends('layouts.main')
@section('title',$saving->type)
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-target bg-c-green"></i>
                    <div class="d-inline">
                        <h5>{{$saving->type}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('saving/savings')}}">Savings</a></li>
                        <li class="breadcrumb-item active"><a href="#">Savings</a></li>
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
                                         src="{{asset('images/savings.gif')}}" alt="img">
                                    <h4 class="text-c-green mt-2">{{$saving->member->firstname.' '.$saving->member->lastname}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection