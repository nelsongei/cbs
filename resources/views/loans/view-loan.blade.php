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
                                                {{\App\Models\LoanTransaction::getLoanBalance($loan)}}
                                            </p>
                                            <strong class="text-warning">
                                                <i class="fa fa-book mr-1"></i>Date Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                {{date('Y-F-d',strtotime($loan->date_disbursed))}}
                                            </p>
                                            <strong class="text-danger">
                                                <i class="fa fa-book mr-1"></i>Amount Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                {{asMoney($loan->approved->amount_approved)}}
                                            </p>
                                            <strong class="text-c-green">
                                                <i class="fa fa-book mr-1"></i>Principal Paid
                                            </strong>
                                            <p class="text-muted">
                                                {{asMoney(\App\Models\LoanApplication::getPrincipalBal($loan))}}
                                            </p>
                                            <strong class="text-primary">
                                                <i class="fa fa-book mr-1"></i>Interest Due
                                            </strong>
                                            <p class="text-muted">
                                                {{asMoney(\App\Models\LoanTransaction::getInterestDue($loan))}}
                                            </p>
                                            <strong class="text-primary">
                                                <i class="fa fa-book mr-1"></i>Loan Period
                                            </strong>
                                            <p class="text-muted">
                                                {{$loan->period}} Months
                                            </p>
                                            <strong class="text-pinterest">
                                                <i class="fa fa-book mr-1"></i>Interest Rate
                                            </strong>
                                            <p class="text-muted">
                                                {{$loan->interest_rate}} %
                                            </p>
                                            <strong class="text-pinterest">
                                                <i class="fa fa-book mr-1"></i>Principal Due
                                            </strong>
                                            <p class="text-muted">
                                                {{asMoney(round(\App\Models\LoanTransaction::getPrincipalDue($loan),1))}}
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
                                                                $count = 0;
                                                                ?>
                                                                <tr>
                                                                    <td>{{$count++}}</td>
                                                                    <td>
                                                                        {{date('d-F-Y',strtotime($loan->date_disbursed))}}
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
                                                                $total_principal = 0; $amount_given = $loan->approved->amount_approved;
                                                                $loan_balance = (float)$loan->approved->amount_approved + (float)$loan->top_up_amount;
                                                                $amountGiven = $loan_balance;

                                                                $total_interest = 0;
                                                                $loanproduct = App\Models\LoanProduct::findorfail($loan->loan_product_id);
                                                                $formula = $loanproduct->formula; $amortization = $loanproduct->amortization;
                                                                for ($i = 1;
                                                                     $i <= $period;
                                                                     $i++)
                                                                {
                                                                    $installment = App\Models\LoanTransaction::getInstallment($loan, '0');

                                                                    $rate = App\Models\LoanTransaction::getrate($loan);
                                                                    $interest_due = $loan_balance * $rate;
                                                                    $loan_balance -= $installment;
                                                                    if ($amortization == "EP" && $formula == "SL") {
                                                                        $principal_due = (float)$amountGiven / (int)$period;

                                                                    } else {
                                                                        $principal_due = $installment - $interest_due;
                                                                    }
                                                                    if ($i > $period2 && $period > $period2) {
                                                                        $total_interest += $installment;
                                                                    } else if ($period == $period2) {
                                                                        $total_interest = $loan_balance * -1;
                                                                    }
                                                                    ?>
                                                                <tr>
                                                                    <td>{{$i}}</td>
                                                                    <td>{{$date}}</td>
                                                                    <td>{{ asMoney($principal_due) }}</td>
                                                                    <td>
                                                                        {{ asMoney($interest_due)}}</td>
                                                                    <td>{{ asMoney($principal_due + $interest_due)}}</td>
                                                                    <td>{{asMoney($first_total - (($i) * $principal_amount))}} </td>
                                                                </tr>
                                                                    <?php
                                                                    $days = $days + 30;
                                                                    $date = date('t-F-Y', strtotime($date . ' + 28 days'));
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="transaction" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="float-right mb-3">
                                                                <button class="btn bn-sm btn-round btn-outline-info">
                                                                    Loan Statements
                                                                </button>
                                                                <button class="btn bn-sm btn-round btn-outline-warning"
                                                                        data-toggle="modal" data-target="#repayLoan">
                                                                    Loan Repayment
                                                                </button>
                                                                @if(\App\Models\LoanTransaction::getLoanBalance($loan)<1)
                                                                    <button
                                                                        class="btn bn-sm btn-round btn-outline-info">
                                                                        Loan Statements
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            <table class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Date</th>
                                                                    <th>Description</th>
                                                                    <th>Credit(Cr)</th>
                                                                    <th>Debit(Dr)</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $i = 2;
                                                                $balance = $loan->approved->amount_approved + \App\Models\LoanApplication::getInterestAmount($loan);
                                                                ?>
                                                                <tr>
                                                                    <td> 1</td>
                                                                    <td>

                                                                        <?php

                                                                        $date = date("d-M-Y", strtotime($loan->date_disbursed));
                                                                        ?>

                                                                        {{ $date}}</td>
                                                                    <td>Loan disbursement</td>

                                                                    <td> 0.00</td>
                                                                    <td>{{ asMoney($loan->approved->amount_approved)}}</td>
                                                                    <td>

                                                                        <a href="{{ URL::to('loantransactions/receipt/')}}"
                                                                           target="_blank"> <span
                                                                                class="glyphicon glyphicon-file"
                                                                                aria-hidden="true"></span> Receipt</a>
                                                                    </td>
                                                                </tr>
                                                                @foreach($loan->transactions as $transaction)
                                                                    @if($transaction->description != 'loan disbursement')
                                                                        <tr>

                                                                            <td> {{ $i }}</td>
                                                                            <td>
                                                                                    <?php
                                                                                    $date = date("d-M-Y", strtotime($transaction->date));
                                                                                    ?>

                                                                                {{ $date }}</td>
                                                                            <td>{{ $transaction->description }}</td>
                                                                            @if( $transaction->type == 'debit')
                                                                                <td>
                                                                                        <?php $creditamount = 0; ?>
                                                                                    0.00
                                                                                </td>
                                                                                <td>{{ asMoney($transaction->amount)}}</td>

                                                                            @endif
                                                                            @if( $transaction->type == 'credit')

                                                                                <td>
                                                                                        <?php $creditamount = $transaction->amount; ?>

                                                                                    {{ asMoney($transaction->amount) }}</td>
                                                                                <td>0.00</td>
                                                                            @endif

                                                                            <!--
          <td>
                                                                                 <?php $balance = $balance - $creditamount; ?>
                                                                            {{ asMoney($balance) }}
                                                                            </td>
-->

                                                                            <td>
                                                                                <a href="{{ URL::to('loantransactions/receipt/'.$transaction->id)}}"
                                                                                   target="_blank"> <span
                                                                                        class="fa fa-file"
                                                                                        aria-hidden="true"></span>
                                                                                    Receipt</a>
                                                                            </td>
                                                                        </tr>
                                                                            <?php $i++; ?>
                                                                    @endif
                                                                    <tr>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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
    @php
        $loanbalance = \App\Models\LoanTransaction::getLoanBalance($loan);
        $interest_due = \App\Models\LoanTransaction::getInterestDue($loan);
        $principal_due = \App\Models\LoanTransaction::getPrincipalDue($loan);
        //dd($principal_due);
    @endphp
    <div id="repayLoan" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Loan Balance</label>
                            <input type="text" name="balance" class="form-control" id="date"
                                   value="{{\App\Models\LoanTransaction::getLoanBalance($loan)}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Interest Due</label>
                            <input type="text" name="balance" class="form-control" id="date"
                                   value="{{\App\Models\LoanTransaction::getInterestDue($loan)}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Amount Due</label>
                            <input type="text" name="balance" class="form-control" id="date"
                                   value="{{round($principal_due+$interest_due,0)}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date">Repayment Date</label>
                            <input type="text" name="date" class="form-control datepicker" id="date">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" name="amount" class="form-control" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="description">Bank Reference</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" data-dismiss="modal">
                            Repay Loan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
