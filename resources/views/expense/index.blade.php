@extends('layouts.main')
@section('title','Expenses')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-calculator bg-info"></i>
                    <div class="d-inline">
                        <h5>Expenses</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Expenses</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal"
                                    data-target="#addExpense">
                                Add Expense
                            </button>
                            <table class="table table-bordered table-striped mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $count = 1;
                                ?>
                                @forelse($expenses as $expense)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$expense->particular->name}}</td>
                                        <td>{{$expense->amount}}</td>
                                        <td>{{$expense->description}}</td>
                                        <td>{{$expense->date}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-info"
                                                    data-toggle="modal" data-target="#editChart{{$expense->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-align-center">
                                            <i class="fa fa-file-excel fa-5x text-c-purple"></i>
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
    <div class="modal fade" id="addExpense">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('journals/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control datepicker" name="date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="particular_id">Particulars</label>
                            <select class="form-control selectable" name="particular_id" id="particular_id" required>
                                @foreach($particulars as $particular)
                                    <option value="{{ $particular->id }}">{{ $particular->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="narration">Narration</label>
                            <select class="form-control selectable" name="narration" id="narration" required>
                                @foreach($members as $member)
                                    <option
                                        value="{{ $member->id }}">{{ $member->firstname.' '.$member->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn-sm btn btn-round btn-outline-warning" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn-sm btn btn-round btn-outline-success" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
