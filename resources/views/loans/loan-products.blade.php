@extends('layouts.main')
@section('title','Loan Products')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Loan Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Loan Products</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#loanProduct">
                                Add Product
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Short Name</th>
                                    <th>Formula</th>
                                    <th>Interest Rate</th>
                                    <th>Period</th>
                                    <th>Currency</th>
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
    <div class="modal fade" id="loanProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="short_name">Short Name</label>
                            <input type="text" name="short_name" class="form-control" id="short_name">
                        </div>
                        <div class="form-group">
                            <label for="formula">Formula</label>
                            <input type="text" name="formula" class="form-control" id="formula">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn-sm btn btn-outline-warning btn-round" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn-sm btn btn-outline-success btn-round" type="submit">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
