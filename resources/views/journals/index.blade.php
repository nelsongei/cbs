@extends('layouts.main')
@section('title','Journals')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-jfi-plus-circle bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Journals</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Journals</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addJournal">
                                Add Journal
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction #</th>
                                    <th>Account Category</th>
                                    <th>Account Name</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                ?>
                                @forelse($journals as $journal)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$journal->trans_no}}</td>
                                        <td>{{$journal->account->category->name}}</td>
                                        <td>{{$journal->date}}</td>
                                        <td>{{$journal->amount}}</td>
                                        <td>{{$journal->type}}</td>
                                        <td>{{$journal->type}}</td>
                                        <td>
                                            @if($journal->archived===0)
                                                Active
                                            @else
                                                Deactivate
                                            @endif
                                        </td>
                                        <td></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" align="center">
                                            <i class="fa fa-file-excel fa-5x"></i>
                                            <p>Add Journals</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="col-sm-12 pull-left">
                                {{$journals->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addJournal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('journals/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="form-group">
                            <label for="particular_id">Particular</label>
                            <select name="particular_id" class="form-control" id="particular_id">
                                @foreach($particulars as $particular)
                                    <option value="{{$particular->id}}">{{$particular->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="narration">Narration</label>
                            <select name="narration" class="form-control" id="narration">
                                @foreach($members as $member)
                                    <option value="{{$member->id}}">{{$member->firstname.' '.$member->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bank_reference">Transaction Reference</label>
                            <input type="text" class="form-control" id="bank_reference" name="bank_reference">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
