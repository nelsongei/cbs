@extends('layouts.main')
@section('title','Assets')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-check bg-primary"></i>
                    <div class="d-inline">
                        <h5>Asset Category</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Asset Category</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addCategory">
                                Add Category
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Asset Category Name</th>
                                    <th>Asset Category Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                ?>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$category->category}}</td>
                                        <td>{{$category->asset_type}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#editCategory{{$category->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" align="center">
                                            <i class="fa fa-cube fa-5x text-c-orenge"></i>
                                            <p>Add Asset Category</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('asset/category/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" class="form-control" id="category">
                        </div>
                        <div class="form-group">
                            <label for="asset_type">Asset Type</label>
                            <select name="asset_type" class="form-control" id="asset_type">
                                <option>Consumables</option>
                                <option>Fixed Asset</option>
                                <option>Services</option>
                                <option>Products</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
