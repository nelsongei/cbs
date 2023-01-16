@extends('layouts.main')
@section('title', 'Interest')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-futbol bg-behance"></i>
                    <div class="d-inline">
                        <h5>Other Income</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Other Income</a></li>
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
                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                data-target="#interest">
                                New Interest
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="interest">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Type</label>
                            <select name="type" class="form-control">
                                <option value="">Intrest</option>
                                <option value="">Other Income</option>
                                <option value="">Expediture</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-round">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
