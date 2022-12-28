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
                                                <i class="fa fa-book mr-1"></i>Interest Due
                                            </strong>
                                            <p class="text-muted">
                                                <span id="interestDue"><</span>
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
                                                {{-- {{ asMoney(round(\App\Models\LoanTransaction::getPrincipalDue($loan), 1)) }} --}}
                                            </p>
                                            <strong class="text-inverse">
                                                <i class="fa fa-book mr-1"></i>Amount Paid
                                            </strong>
                                            <p class="text-muted">
                                                {{-- {{ asMoney(round(\App\Models\LoanTransaction::checkHowMuchPaid($loan->id), 1)) }} --}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="loanIds" value="{{ $loan->id }}">
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
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
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        $(document).ready(function(){
            var loan = document.getElementById("loanIds").value;
            $.ajax({
                type: "GET",
                url: "https://127.0.0.1/payroll-system/public/loan/balance/" + loan,
                success: function(response){
                    console.log(response);
                    document.getElementById("loanBalance").innerText = response.total;
                    document.getElementById("interestDue").innerText = Math.round(response.interest,0);
                    
                }
            })
        });
    </script>
@endsection
