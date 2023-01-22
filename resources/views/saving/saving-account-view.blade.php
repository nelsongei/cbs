@extends('layouts.main')
@section('title',$account->product->name)
@section('content')
    <?php

    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-bar-chart bg-success"></i>
                    <div class="d-inline">
                        <h5>{{$account->product->name.' -- '.$account->account_number}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('saving/accounts')}}">Saving Accounts</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{$account->account_number}}</a></li>
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
                                            <img class="img-fluid img-rounded img-circle img-150" src="{{asset('images/save.gif')}}" alt="img">
                                            <h4 class="text-c-blue">{{$account->member->firstname.' '.$account->member->lastname}}</h4>
                                            <h4 class="text-success">{{$account->account_number}}</h4>
                                            <h4 class="text-bold text-dribbble">Account Balance: {{asMoney(\App\Models\SavingAccount::sumAmount($account->id,$account->member->id))}}</h4>

                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <hr/>
                                            <strong class="text-c-orenge">
                                                <i class="fa fa-check-circle mr-1"></i>Member Number
                                            </strong>
                                            <p class="text-muted">
                                                {{$account->member->membership_no}}
                                            </p>
                                            <hr/>
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Account Balance
                                            </strong>
                                            <p class="text-muted">
                                                {{asMoney(\App\Models\SavingAccount::sumAmount($account->id,$account->member->id))}}
                                            </p>
                                            <hr/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-sm btn-round btn-outline-success mb-2" data-toggle="modal" data-target="#exprortStatement">
                                                Export
                                            </button>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Description</th>
                                                    <th>Credit(CR)</th>
                                                    <th>Debit(DR)</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <?php $count=1?>
                                                @forelse($account->savings as $saving)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>{{$saving->description}}</td>
                                                        <td>{{asMoney($saving->where('type','credit')->where('id',$saving->id)->sum('saving_amount'))}}</td>
                                                        <td>{{asMoney($saving->where('type','debit')->where('id',$saving->id)->sum('saving_amount'))}}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-success btn-round dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item text-info" href="{{url('saving/receipt/'.$saving->id)}}">Receipt</a>
                                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" align="center">
                                                            <i class="fa fa-file-alt fa-5x text-warning"></i>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </table>
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
    <div class="modal fade" id="exprortStatement">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
