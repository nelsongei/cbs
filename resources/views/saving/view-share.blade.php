@extends('layouts.main')
@section('title',$share->account_number)
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-info bg-c-orenge"></i>
                    <div class="d-inline">
                        <h5>{{$share->account_number}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{url('members/view/'.$share->member->id)}}">{{$share->member->firstname.' '.$share->member->lastname}}</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">{{$share->account_number}}</a></li>
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
                                            <img class="img-fluid img-rounded img-circle img-150"
                                                 src="{{asset('images/share.gif')}}" alt="img">
                                            <h4 class="text-c-blue">{{$share->member->firstname.' '.$share->member->lastname}}</h4>
                                            <h4 class="text-success">{{$share->account_number}}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-sm btn-outline-info btn-round" data-toggle="modal"
                                                    data-target="#shares">
                                                Purchase Shares
                                            </button>
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
    <div class="modal fade" id="shares">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="transaction">Transaction</label>
                            <select name="transaction" id="transaction" class="form-control">
                                <option>Purchase</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date"> Date</label>
                            <input class="form-control" placeholder="" type="date" name="date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" min="0" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
