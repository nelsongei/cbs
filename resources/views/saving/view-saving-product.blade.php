@extends('layouts.main')
@section('title',$product->name)
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
                    <i class="feather icon-target bg-c-green"></i>
                    <div class="d-inline">
                        <h5>{{$product->name}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('/saving/products')}}">Saving Product</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{$product->name}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img class="img-fluid img-rounded img-circle img-150"
                                         src="{{asset('images/graph.gif')}}" alt="img">
                                    <h4 class="text-c-blue mt-2">{{$product->name}}</h4>
                                    <h4 class="text-c-green mt-2">{{$product->shortname}}</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <strong class="text-c-orenge">
                                        <i class="fa fa-check-circle mr-1"></i>Savings
                                    </strong>
                                    <p class="text-muted">
                                        {{count($product->accounts)}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-blue">
                                        <i class="fa fa-crosshairs"></i>Total Savings
                                    </strong>
                                    <p class="text-muted">
                                        {{asMoney($product->accounts->sum('saving_amount'))}}
                                    </p>
                                    <hr/>
                                    <strong class="text-success">
                                        <i class="fa fa-angle-double-up"></i>Opening Balance
                                    </strong>
                                    <p class="text-muted">
                                        {{asMoney($product->opening_balance)}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-orenge">
                                        <i class="fa fa-chart-bar"></i>Saving Accounts
                                    </strong>
                                    <p class="text-muted">
                                        {{count($product->accounts)}}
                                    </p>
                                    <hr/>
                                    <strong class="text-pink">
                                        <i class="fa fa-chart-area"></i>Calculated As
                                    </strong>
                                    <p class="text-muted">
                                        @if ($product->calculate_as =='cp')
                                        Compounding
                                            @else
                                            Straight
                                        @endif
                                    </p>
                                    <hr/>
                                    <strong class="text-success">
                                        <i class="fa fa-check"></i>Type
                                    </strong>
                                    <p class="text-muted">
                                        {{$product->type}}
                                    </p>
                                    <hr/>
                                    <strong class="text-primary">
                                        <i class="fa fa-percent"></i>Interest Rate
                                    </strong>
                                    <p class="text-muted">
                                        {{$product->interest_rate}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a href="#chart" class="active nav-link"
                                               data-toggle="tab">Chart Representation</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#savings" class="nav-link"
                                               data-toggle="tab">Savings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#posting" class="nav-link" data-toggle="tab">
                                                Saving Postings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="chart" class="tab-pane active">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div>
                                                        {!! $savingChart->container() !!}
                                                        {!! $savingChart->script() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="savings" class="tab-pane">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Member Name</th>
                                                            <th>Member Number</th>
                                                            <th>Account Number</th>
                                                            <th>Payment Method</th>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </thead>
                                                        <?php
                                                        $count = 1;
                                                        ?>
                                                        <tbody>
                                                        @forelse($product->accounts as $account)
                                                            <tr>
                                                                <td>{{$count++}}</td>
                                                                <td>{{$account->member->firstname.' '.$account->member->lastname}}</td>
                                                                <td>{{$account->member->membership_no}}</td>
                                                                <td>{{$account->account->account_number}}</td>
                                                                <td>{{$account->payment_method}}</td>
                                                                <td>{{$account->saving_amount}}</td>
                                                                <td>{{$account->date}}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" align="center">
                                                                    <i class="fa fa-file fa-5x text-c-blue"></i>
                                                                    <p class="text-muted">This Saving Product Has No Savings</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="posting" class="tab-pane">
                                            <div class="card">
                                                <div class="card-body">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Transaction</th>
                                                            <th>Debit Account</th>
                                                            <th>Credit Account</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $count=1;?>
                                                        @foreach($product->postings as $posting)
                                                            <tr>
                                                                <th>{{$count++}}</th>
                                                                <td>{{$posting->transaction}}</td>
                                                                <td>{{$posting->debit_account->name}}</td>
                                                                <td>{{$posting->credit_account->name}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

