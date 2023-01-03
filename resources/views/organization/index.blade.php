@extends('layouts.main')
@section('title', 'Organization')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-home bg-success"></i>
                    <div class="d-inline">
                        <h5>Organization</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Organization</a></li>
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
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            @if ($organization->logo == null)
                                                <img src="{{ asset('images/logo.jpg') }}"
                                                    class="img-fluid img-rounded img-circle w-100">
                                            @else
                                                <img src="{{ asset('images/logo.png') }}"
                                                    class="img-fluid img-rounded img-circle w-100">
                                            @endif
                                            <h4 class="text-info">{{ $organization->name }}</h4>
                                            <h4 class="text-success">{{ $organization->email }}</h4>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Name
                                            </strong>
                                            <p class="text-muted">
                                                {{ $organization->name }}
                                            </p>
                                            <hr>
                                            <strong class="text-info">
                                                <i class="fa fa-envelope mr-1"></i>Email
                                            </strong>
                                            <p class="text-muted">
                                                {{ $organization->email }}
                                            </p>
                                            <hr>
                                            <strong class="text-warning">
                                                <i class="fa fa-globe mr-1"></i>Website
                                            </strong>
                                            <p class="text-muted">
                                                {{ $organization->website ? $organization->website : 'N/A' }}
                                            </p>
                                            <hr>
                                            <strong class="text-c-green">
                                                <i class="fa fa-phone mr-1"></i>Phone
                                            </strong>
                                            <p class="text-muted">
                                                {{ $organization->phone ? $organization->phone : 'N/A' }}
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <a href="#update" class="active nav-link"
                                                       data-toggle="tab">Update</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#logo" class="nav-link"
                                                       data-toggle="tab">Update Logo</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div id="update" class="tab-pane active"></div>
                                                <div id="logo" class="tab-pane"></div>
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
    </div>
@endsection
