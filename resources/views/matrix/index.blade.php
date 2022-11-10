@extends('layouts.main')
@section('title','Guarantor Matrix')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-bar bg-primary"></i>
                    <div class="d-inline">
                        <h5>Guarantor Matrix</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Guarantor Matrix</a></li>
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
                                    data-target="#matrix">
                                Add Matrix
                            </button>
                            <table class="table table-bordered table-striped mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Matrix Name</th>
                                    <th>Maximum Amount</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                ?>
                                @forelse($matrices as $matrix)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$matrix->name}}</td>
                                        <td>{{$matrix->maximum}}</td>
                                        <td>{{$matrix->description}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#edit{{$matrix->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit{{$matrix->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('/matrix/update')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$matrix->id}}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">Matrix Name</label>
                                                            <input type="text" name="name" id="name" class="form-control" value="{{$matrix->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="maximum">Maximum Amount To Guarantee</label>
                                                            <input type="text" name="maximum" id="maximum" class="form-control" value="{{$matrix->maximum}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" id="description" class="form-control">{!! $matrix->description !!}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-success btn-round">
                                                            Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" align="center">
                                            <i class="fa fa-magic fa-5x text-pinterest"></i>
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
    <div class="modal fade" id="matrix">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('/matrix/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Matrix Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="maximum">Maximum Amount To Guarantee</label>
                            <input type="text" name="maximum" id="maximum" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
