@extends('layouts.main')
@section('title','Disbursement Options')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-plus bg-primary"></i>
                    <div class="d-inline">
                        <h5>Disbarment Options</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Disbarment Options</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addOption">
                                Add Option
                            </button>
                            <table class="table table-bordered table-striped mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Minimum Amount</th>
                                    <th>Maximum Amount</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                ?>
                                @forelse($disbursments as $disbursment)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$disbursment->name}}</td>
                                        <td>{{$disbursment->min}}</td>
                                        <td>{{$disbursment->max}}</td>
                                        <td>{{$disbursment->description}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#editChart{{$disbursment->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center">
                                            <i class="fa fa-plus fa-5x text-info"></i>
                                            <p>Add Disbarment Options</p>
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
    <div class="modal fade" id="addOption">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('/disbursements/store')}}">
                    <div id="page1">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Disbursement Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="min">Minimum Amount</label>
                                <input type="text" name="min" class="form-control" id="min">
                            </div>
                            <div class="form-group">
                                <label for="max">Maximum Amount</label>
                                <input type="text" name="max" class="form-control" id="max">
                            </div>
                            <div class="form-group">
                                <label for="description">Disbursement Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn-sm btn btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn-sm btn btn-outline-success btn-round">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
