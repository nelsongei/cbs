@extends('layouts.main')
@section('title',$loan->account_number)
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>{{$loan->account_number}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('loan/loan_application')}}">Loans</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{$loan->account_number}}</a></li>
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
                                            <img class="img-fluid img-rounded img-circle img-100"
                                                 src="{{asset('images/payroll2.gif')}}" alt="img">
                                            <h4 class="text-c-blue">{{$loan->member->firstname.' '.$loan->member->lastname}}</h4>
                                            <h4 class="text-success">{{$loan->account_number}}</h4>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Loan type
                                            </strong>
                                            <p class="text-muted">
                                                {{$loan->loanType->name}}
                                            </p>
                                            <strong class="text-info">
                                                <i class="fa fa-book mr-1"></i>Loan Balance
                                            </strong>
                                            <p class="text-muted">
                                                10000
                                            </p>
                                            <strong class="text-warning">
                                                <i class="fa fa-book mr-1"></i>Date Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                11/11/2022
                                            </p>
                                            <strong class="text-danger">
                                                <i class="fa fa-book mr-1"></i>Amount Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                10000
                                            </p>
                                            <strong class="text-c-green">
                                                <i class="fa fa-book mr-1"></i>Principal Paid
                                            </strong>
                                            <p class="text-muted">
                                                0
                                            </p>
                                            <strong class="text-c-orenge">
                                                <i class="fa fa-book mr-1"></i>Amount Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                2000
                                            </p>
                                            <strong class="text-primary">
                                                <i class="fa fa-book mr-1"></i>Principal Balance
                                            </strong>
                                            <p class="text-muted">
                                                2000
                                            </p>
                                            <strong class="text-primary">
                                                <i class="fa fa-book mr-1"></i>Loan Period
                                            </strong>
                                            <p class="text-muted">
                                                3 Months
                                            </p>
                                            <strong class="text-pinterest">
                                                <i class="fa fa-book mr-1"></i>Interest Rate
                                            </strong>
                                            <p class="text-muted">
                                                3 %
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <a href="#schedule" class="active nav-link"
                                                       data-toggle="tab">Loan Schedule</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#transaction" class="nav-link"
                                                       data-toggle="tab">Loan Transactions</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#more" class="nav-link"
                                                       data-toggle="tab">More Information</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#docs" class="nav-link"
                                                       data-toggle="tab">Loan Documents</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div id="schedule" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Installment #</th>
                                                                    <th>Date</th>
                                                                    <th>Principal</th>
                                                                    <th>Interest</th>
                                                                    <th>Total</th>
                                                                    <th>Loan Balance</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $count = 1;
                                                                ?>
                                                                <tr>
                                                                    <td>{{$count++}}</td>
                                                                    <td>
                                                                        {{date('Y-F-d',strtotime($loan->date_disbursed))}}
                                                                    </td>
                                                                    @php
                                                                        function asMoney($value)
                                                                        {
                                                                            return number_format($value, 2);
                                                                        }
                                                                        $first_amount = $loan->approved->amount_approved+$loan->top_up_amount;
                                                                        $first_rate = ($loan->interest_rate) / 100;
                                                                        $first_interest = 0.00;
                                                                        $first_total = $first_amount + $first_interest;
                                                                    @endphp
                                                                    <td>
                                                                        {{asMoney($first_amount)}}
                                                                    </td>
                                                                    <td>{{asMoney($first_interest)}}</td>
                                                                    <td>{{asMoney($first_total)}}</td>
                                                                    <td>{{asMoney($first_total)}}</td>
                                                                </tr>
                                                                <?php
                                                                $dateX = strtotime($loan->date_disbursed);
                                                                $date = date("Y-m-t", $dateX);
                                                                $dateY = strtotime($date) + 87000;
                                                                $date = date("t-F-Y", $dateY);
                                                                $interest = \App\Models\LoanApplication::getInterestAmount($loan);
                                                                $principal = $loan->amount_applied + $loan->top_up_amount;
                                                                $balance = $first_total;
                                                                $days = 0;
                                                                $totalint = 0;
                                                                $period2 = App\Models\LoanTransaction::getInstallment($loan, 'period');
                                                                $period2 = round($period2);
                                                                $period = $loan->period;
                                                                $principal_amount = App\Models\LoanTransaction::getPrincipalDue($loan);
                                                                ?>
                                                                <tr>
                                                                    <td>{{$count++}}</td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="transaction" class="tab-pane"></div>
                                                <div id="more" class="tab-pane"></div>
                                                <div id="docs" class="tab-pane"></div>
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
@endsection
