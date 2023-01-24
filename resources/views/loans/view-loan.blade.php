@extends('layouts.main')
@section('title', $loan->account_number)
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
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>{{ $loan->account_number }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('loan/loan_application') }}">Loans</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{ $loan->account_number }}</a></li>
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
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <img class="img-fluid img-rounded img-circle img-100"
                                                src="{{ asset('images/payroll2.gif') }}" alt="img">
                                            <h4 class="text-c-blue">
                                                {{ $loan->member->firstname . ' ' . $loan->member->lastname }}</h4>
                                            <h4 class="text-success">{{ $loan->account_number }}</h4>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Loan type
                                            </strong>
                                            <p class="text-muted">
                                                {{ $loan->loanType->name }}
                                            </p>
                                            <strong class="text-info">
                                                <i class="fa fa-book mr-1"></i>Loan Balance
                                            </strong>
                                            <p class="text-muted">
                                                <span id="loanBalance"></span>
                                            </p>
                                            <strong class="text-warning">
                                                <i class="fa fa-book mr-1"></i>Date Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                {{ date('Y-F-d', strtotime($loan->date_disbursed)) }}
                                            </p>
                                            <strong class="text-danger">
                                                <i class="fa fa-book mr-1"></i>Amount Disbursed
                                            </strong>
                                            <p class="text-muted">
                                                {{ asMoney($loan->approved->amount_approved) }}
                                            </p>
                                            <strong class="text-c-green">
                                                <i class="fa fa-book mr-1"></i>Principal Balance
                                            </strong>
                                            <p class="text-muted">
                                                {{ asMoney(\App\Models\LoanApplication::getPrincipalBal($loan)) }}
                                            </p>
                                            <strong class="text-primary">
                                                <i class="fa fa-check mr-1"></i>Interest Due
                                            </strong>
                                            <p class="text-muted">
                                                <span id="interestDue">
                                                </span>
                                            </p>
                                            <strong class="text-success">
                                                <i class="fa fa-paperclip mr-1"></i>Interest Paid
                                            </strong>
                                            <p class="text-muted">
                                                {{ $interest_paid }}
                                            </p>
                                            <strong class="text-c-purple">
                                                <i class="fa fa-clock mr-1"></i>Loan Period
                                            </strong>
                                            <p class="text-muted">
                                                {{ $loan->period }} Months
                                            </p>
                                            <strong class="text-pinterest">
                                                <i class="fa fa-percent mr-1"></i>Interest Rate
                                            </strong>
                                            <p class="text-muted">
                                                {{ $loan->interest_rate }} %
                                            </p>
                                            <strong class="text-c-blue">
                                                <i class="fa fa-angle-double-up mr-1"></i>Principal Due
                                            </strong>
                                            <p class="text-muted">
                                                <span id="principalDue"></span>
                                            </p>
                                            <strong class="text-c-green">
                                                <i class="feather icon-codepen mr-1"></i>Principal Paid
                                            </strong>
                                            <p class="text-muted">
                                                {{ $principal_paid }}
                                            </p>
                                            <strong class="text-inverse">
                                                <i class="fa fa-book mr-1"></i>Amount Paid
                                            </strong>
                                            <p class="text-muted">
                                                {{ $loan->transactions->where('description','loan repayment')->sum('amount') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="loanIds" value="{{ $loan->id }}">
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <a href="#schedule" class="active nav-link" data-toggle="tab">Loan
                                                        Schedule</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#transaction" class="nav-link" data-toggle="tab">Loan
                                                        Transactions</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#repayments" class="nav-link" data-toggle="tab">Loan Repayments
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#topups" class="nav-link" data-toggle="tab">Loan Topups
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#docs" class="nav-link" data-toggle="tab">Loan Documents</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#docs" class="nav-link" data-toggle="tab">Loan Terms</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div id="schedule" class="tab-pane active">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            @if ($loan->loanType->formula == 'SL' && $loan->loanType->amortization == 'EP')
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Installment #</th>
                                                                        <th>Date</th>
                                                                        <th>Principal</th>
                                                                        <th>Interest</th>
                                                                        <th>Amount To Be Paid</th>
                                                                        <th>Loan Balance</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>0</td>
                                                                        <td>
                                                                            {{ date('d-F-Y', strtotime($loan->date_disbursed)) }}
                                                                        </td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>
                                                                        <td>0.0</td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                            $dateX = strtotime($loan->date_disbursed);
                                                                            $date = date('Y-m-t', $dateX);
                                                                            $dateY = strtotime($date) + 87000;
                                                                            $date = date('t-F-Y', $dateY);
                                                                            $days = 0;
                                                                            $period = $loan->period; //4 or any other period in months
                                                                            $amount = $loan->approved->amount_approved + $loan->topups->sum('amount_topup'); //4000
                                                                            $total = 0;
                                                                            $totalInterest = 0;
                                                                        @endphp
                                                                        @for ($i = 1; $i <= $loan->period; $i++)
                                                                            @php
                                                                                $rate = $loan->interest_rate / 100;
                                                                                $principal = ($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) / $loan->period;
                                                                                $payment = ($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) / $loan->period;
                                                                                $interest = $amount * $rate;
                                                                                $principal += $interest;
                                                                                $amount -= $payment;
                                                                                $total += $principal;
                                                                                $totalInterest += $interest;
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{ $i }}</td>
                                                                                <td>{{ $date }}</td>
                                                                                <td>
                                                                                    {{ asMoney($payment) }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ asMoney($interest) }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ asMoney($principal) }}
                                                                                </td>
                                                                                <td>{{ asMoney($amount) }}</td>
                                                                            </tr>
                                                                            @php
                                                                                $days = $days + 30;
                                                                                $date = date('t-F-Y', strtotime($date . ' + 28 days'));
                                                                            @endphp
                                                                        @endfor
                                                                        <tr>
                                                                            <th colspan="3"
                                                                                class="text-success text-center">Totals
                                                                            </th>
                                                                            <th class="text-primary">{{ $totalInterest }}
                                                                            </th>
                                                                            <th class="text-primary">{{ $total }}
                                                                            </th>
                                                                        </tr>
                                                                </tbody>
                                                            </table>
                                                            @endif
                                                            @if ($loan->loanType->formula == 'RB' && $loan->loanType->amortization == 'EI')
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Installment #</th>
                                                                        <th>Date</th>
                                                                        <th>Monthly Payment</th>
                                                                        <th>Reducing Balance</th>
                                                                        <th>Interest</th>
                                                                        <th>Loan Balance</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>0</td>
                                                                        <td>
                                                                            {{ date('d-F-Y', strtotime($loan->date_disbursed)) }}
                                                                        </td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>

                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>
                                                                        <td>0.0</td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup') }}
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                            $dateX = strtotime($loan->date_disbursed);
                                                                            $date = date('Y-m-t', $dateX);
                                                                            $dateY = strtotime($date) + 87000;
                                                                            $date = date('t-F-Y', $dateY);
                                                                            $days = 0;
                                                                        $year = $loan->period/12;
                                                                        $period1 = $loan->loanType->period;
                                                                        $amount  =($loan->approved->amount_approved+$loan->topups->sum('amount_topup'));
                                                                        $totals1 = 0;
                                                                        $totalInt = 0;
                                                                        for ($i=1; $i <=$period1 ; $i++) { 
                                                                            # code...
                                                                            $rate = $loan->loanType->interest_rate/100;
                                                                            $top = (pow((1 + $rate / 12), $period1) * ($rate / 12));
                                                                            $below = (pow((1 + ($rate / 12)), $period1) - 1);
                                                                            $monthlyPayments = (($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) * $top) / $below;
                                                                            $interest12 = $amount * $rate * $year / $loan->period;
                                                                            $newMP = (($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) * $top) / $below;
                                                                            $rb =  $newMP -= $interest12;
                                                                            $amount -= $rb;
                                                                            $totals1 +=$monthlyPayments;
                                                                            $totalInt +=$interest12
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{ $i }}</td>
                                                                                <td>{{ $date }}</td>
                                                                                <td>{{ asMoney($monthlyPayments) }}</td>
                                                                                <td>{{ asMoney($rb) }}</td>
                                                                                <td>{{ asMoney($interest12) }}</td>
                                                                                <td>{{ asMoney($amount) }}</td>
                                                                                </tr>
                                                                         
                                                                                @php
                                                                                $days = $days + 30;
                                                                                $date = date('t-F-Y', strtotime($date . ' + 28 days'));
                                                                        }
                                                                        @endphp
                                                                        <tr>
                                                                            <th colspan="2" class="text-success text-center">Totals</th>
                                                                            <th >{{ asMoney($totals1) }}</th>
                                                                            <th>Total Interest</th>
                                                                            <th>{{ asMoney($totalInt) }}</th>
                                                                            <th></th>
                                                                        </tr>
                                                                </tbody>
                                                            </table>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="transaction" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn bn-sm btn-round btn-outline-info"
                                                                data-toggle="modal" data-target="#exportStatement">
                                                                Loan Statements
                                                            </button>
                                                            <table class="table table-striped table-bordered mt-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>Credit(Cr)</th>
                                                                        <th>Debit(Dr)</th>
                                                                        <th>Balance</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td> 1</td>
                                                                        <td>

                                                                            <?php
                                                                            
                                                                            $date = date('d-M-Y', strtotime($loan->date_disbursed));
                                                                            ?>

                                                                            {{ $date }}</td>
                                                                        <td>Loan disbursement</td>

                                                                        <td> 0.00</td>
                                                                        <td>{{ asMoney($loan->approved->amount_approved) }}
                                                                        </td>
                                                                        <td>{{ $loan->approved->amount_approved + $loan->topups->sum('amount_topup')  }}
                                                                        </td>
                                                                        <td>

                                                                            <a href="{{ URL::to('loantransactions/receipt/') }}"
                                                                                target="_blank"> <span
                                                                                    class="glyphicon glyphicon-file"
                                                                                    aria-hidden="true"></span> Receipt</a>
                                                                        </td>

                                                                    </tr>
                                                                    <?php $i = 2;
                                                                    $balance = $loan->approved->amount_approved + $loan->topups->sum('amount_topup');
                                                                    ?>
                                                                    @foreach ($loan->transactions as $transaction)
                                                                        @if ($transaction->description != 'loan disbursement')
                                                                            <tr>

                                                                                <td> {{ $i }}</td>
                                                                                <td>
                                                                                    <?php
                                                                                    $date = date('d-M-Y', strtotime($transaction->date));
                                                                                    ?>

                                                                                    {{ $date }}</td>
                                                                                <td>{{ $transaction->description }}</td>
                                                                                @if ($transaction->type == 'debit')
                                                                                    <td>
                                                                                        <?php $creditamount = 0; ?>
                                                                                        0.00
                                                                                    </td>
                                                                                    <td>{{ asMoney($transaction->amount) }}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($transaction->type == 'credit')
                                                                                    <td>
                                                                                        <?php $creditamount = $transaction->amount; ?>

                                                                                        {{ asMoney($transaction->amount) }}
                                                                                    </td>
                                                                                    <td>0.00</td>
                                                                                @endif
                                                                                <td>{{ asMoney($balance -= $creditamount) }}
                                                                                </td>
                                                                                <td>
                                                                                    <a href="{{ URL::to('loantransactions/receipt/' . $transaction->id) }}"
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
                                                <div id="repayments" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn bn-sm btn-round btn-outline-success"
                                                                data-toggle="modal" data-target="#repayLoan">
                                                                Loan Repayment
                                                            </button>
                                                            <table class="table table-striped table-bordered mt-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Date</th>
                                                                        <th>Principal Paid</th>
                                                                        <th>Interest Paid</th>
                                                                        <th>Bank Details</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        $count=1;
                                                                        ?>
                                                                    @forelse ($loan->repayments as $repayment)
                                                                    <tr>
                                                                        <td>{{ $count++ }}</td>
                                                                        <td>{{ $repayment->date }}</td>
                                                                        <td>{{ $repayment->principal_paid }}</td>
                                                                        <td>{{ $repayment->interest_paid }}</td>
                                                                        <td>{{ $repayment->bank_repdetails }}</td>
                                                                    </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="6" align="center">
                                                                                <i class="feather icon-bar-chart fa-5x text-success"></i>
                                                                                <p>No Repayments</p>
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="topups" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button class="btn bn-sm btn-round btn-outline-success"
                                                                data-toggle="modal" data-target="#loanTopups">
                                                                Loan Topups
                                                            </button>
                                                            <table class="table table-striped table-bordered mt-2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Amount</th>
                                                                        <th>Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $count=1?>
                                                                    @forelse ($loan->topups as $topup)
                                                                    <tr>
                                                                        <td>{{ $count++ }}</td>
                                                                        <td>{{ $topup->amount_topup }}</td>
                                                                        <td>{{ $topup->date_topup }}</td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button
                                                                                    class="btn btn-outline-success btn-round dropdown-toggle"
                                                                                    type="button" id="dropdownMenuButton"
                                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                    Action
                                                                                </button>
                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item text-info" data-toggle="modal"
                                                                                        data-target="#edit{{ $topup->id }}">Edit</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @empty    
                                                                    <tr>
                                                                        <td colspan="4" align="center">
                                                                            <i class="fa fa-file fa-5x"></i>
                                                                            <p>No Topups</p>
                                                                        </td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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
    <div class="modal fade" id="loanTopups">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('loan/topup') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$loan->id}}"> 
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="text" class="form-control datepicker" name="top_date">
                        </div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="text" class="form-control" name="top_amount">
                        </div>
                        <div class="form-group">
                            <label for="">Bank Ref</label>
                            <textarea name="bank_ref" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Topup Loan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="repayLoan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('loan/repayment') }}" method="post">
                    @csrf
                    <div class="card">
                        <input type="hidden" value="{{$loan->id}}" name="loan_application_id">
                        <div class="card-body">
                            <strong class="text-success">
                                <i class="fa fa-book mr-1"></i>Principal Due
                            </strong>
                            <p class="text-muted">
                                {{ asMoney($principal_due) }}
                            </p>
                            <strong class="text-success">
                                <i class="fa fa-book mr-1"></i>Interest Due
                            </strong>
                            <p class="text-muted">
                                {{ $interest_due }}
                            </p>
                            <strong class="text-success">
                                <i class="fa fa-book mr-1"></i>Amount Due
                            </strong>
                            <p class="text-muted">
                                {{ asMoney($principal_due+$interest_due) }}
                            </p>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Repayment Date</label>
                            <input type="text" class="form-control datepicker" name="date">
                        </div>
                        <div class="form-group">
                            <label for="">Amount</label>
                            <input type="number" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="">Bank Reference</label>
                            <textarea class="form-control" name="bank_reference" id="bank_reference"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Repay Loan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        $(document).ready(function() {
            var loan = document.getElementById("loanIds").value;
            $.ajax({
                type: "GET",
                url: "http://127.0.0.1/payroll-system/public/loan/balance/" + loan,
                success: function(response) {
                    console.log(response);
                    document.getElementById("loanBalance").innerText = Math.round(response.total,1);
                    document.getElementById("interestDue").innerText = Math.round(response.interest, 0);
                    document.getElementById("principalDue").innerText = Math.round(response
                        .totalPrincipal, 0);
                }
            })
        });
    </script>
@endsection
