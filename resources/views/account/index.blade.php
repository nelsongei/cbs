@extends('layouts.main')
@section('title','Account')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-plus-circle bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Chart of Account</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Chart of Account</a></li>
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
                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal" data-target="#createAccount">
                                Add Account
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $count=1;
                                ?>
                                @forelse($accounts as $account)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$account->category}}</td>
                                        <td>{{$account->name}}</td>
                                        <td>{{$account->code}}</td>
                                        <td>
                                            @if($account->active === 1)
                                            <button class="btn btn-sm btn-outline-success btn-round">
                                                Active
                                            </button>
                                                @else
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-success"
                                                       href="{{url('account/chart/'.$account->id)}}">View</a>
                                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#editChart{{$account->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editChart{{$account->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('account/chart/update')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$account->id}}">
                                                        <div class="form-group">
                                                            <label for="category">Account Category</label>
                                                            <select class="form-control" name="category" id="category">
                                                                <option disabled>select category</option>
                                                                <option disabled>--------------------------</option>
                                                                <option value="ASSET">Asset (1000)</option>
                                                                <option value="INCOME">Income (2000)</option>
                                                                <option value="EXPENSE">Expense (3000)</option>
                                                                <option value="EQUITY">Equity (4000)</option>
                                                                <option value="LIABILITY">Liability (5000)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Account Name</label>
                                                            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{$account->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="code">GL Code</label>
                                                            <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{$account->code}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="active">Active</label>
                                                            <input type="checkbox" name="active" id="active" @if($account->active===1) checked @endif>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                                                            Update Account
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center">
                                            <i class="fa fa-plus-square fa-5x text-success"></i>
                                            <p>Add Account</p>
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
    <div class="modal fade" id="createAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('account/chart/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Account Category</label>
                            <select class="form-control" name="category" id="category">
                                <option disabled>select category</option>
                                <option disabled>--------------------------</option>
                                <option value="ASSET">Asset (1000)</option>
                                <option value="INCOME">Income (2000)</option>
                                <option value="EXPENSE">Expense (3000)</option>
                                <option value="EQUITY">Equity (4000)</option>
                                <option value="LIABILITY">Liability (5000)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Account Name</label>
                            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ old('name') }}}">
                        </div>
                        <div class="form-group">
                            <label for="code">GL Code</label>
                            <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{{ old('code') }}}">
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>&nbsp;&nbsp;
                            <input   type="checkbox" name="active" id="active" value="1">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
