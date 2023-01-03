@extends('layouts.main')
@section('title', 'Users')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-user bg-success"></i>
                    <div class="d-inline">
                        <h5>Users</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addUser">
                                Add User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/') }}" method="post">
                    @csrf
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
