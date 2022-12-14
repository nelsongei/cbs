@extends('layouts.main')
@section('title','Bank Accounts')
@section('content')
    <?php
    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <style type="text/css" media="screen">
        table {
            color: #AAA;
        }

        thead {
            border: 1px solid #ddd;
        }

        thead tr th {
            background: #E1F5FE !important;
            color: #777;
            vertical-align: middle !important;
            padding: 0px 5px !important;
        }

        ul {
            text-align: left;
        }

        h4, h6 {
            margin-bottom: 7px;
            margin-top: 7px;
        }

        h6 {
            color: #777;
        }

        tbody tr {
            text-align: center;
        }

        .bal {
            width: auto;
            display: inline-block;
            margin: 10px 0;
            padding: 0 10px;
            text-align: center;
        }

    </style>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-chart-area bg-c-green"></i>
                    <div class="d-inline">
                        <h5>Bank Accounts</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Bank Accounts</a></li>
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
                                    data-target="#addAccounts">
                                Add Bank Account
                            </button>
                            <button class="btn btn-outline-dark btn-round" data-toggle="modal"
                                    data-target="#addJournal">
                                Transaction Records
                            </button>
                            <button class="btn btn-outline-warning btn-round" data-toggle="modal"
                                    data-target="#addJournal">
                                Download Cashbook
                            </button>
                            <div class="card mt-2">
                                <div class="card-body">
                                    @forelse($bank_accounts as $account)
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="bal">
                                                        <h4><font
                                                                color="#0BAEED">{{ $account->account_name }}</font>
                                                        </h4>
                                                        <h6>{{ $account->account_number }}</h6>
                                                    </div>
                                                    <div class="bal"
                                                         style="border-left: 1px solid #ddd !important;">
                                                        <h4><font
                                                                color="#0BAEED">{{ $account->bank_name }}</font>
                                                        </h4>
                                                        <h6>{{ $account->account_name }}</h6>
                                                    </div>
                                                </th>
                                                <th colspan="2" style="text-align: right !important">
                                                    <div class="dropdown">
                                                        <button
                                                            class="btn btn-outline-success btn-round dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Manage Account
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item text-success" data-toggle="modal"
                                                               data-target="#uploadStatement{{$account->id}}">Upload
                                                                Bank
                                                                Statement</a>
                                                            <a class="dropdown-item text-info" data-toggle="modal"
                                                               data-target="#editChart{{$account->id}}">Convert
                                                                Statement</a>
                                                            <a class="dropdown-item text-warning" href="#">Reconcile
                                                                Account</a>
                                                            <a class="dropdown-item text-danger" href="#">Reconciliation
                                                                Report</a>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="1"
                                                    style="border-bottom: 1px solid #ddd !important;"><font
                                                        color="green">
                                                        <h5>Statement Last Reconciled:
                                                            @if(!empty(App\Models\BankAccount::getLastReconciliation($account->id)))
                                                                {{ App\Models\BankAccount::getLastReconciliation($account->id)->stmt_month }}
                                                            @else
                                                                NEVER
                                                            @endif
                                                        </h5></font>
                                                </td>
                                                <td colspan="2"
                                                    style="vertical-align: middle; border: 1px solid #ddd !important;">
                                                    @if(!empty(App\Models\BankAccount::getLastReconciliation($account->id)))
                                                        <a href="#viewHistory{{$account->id}}"
                                                           class="btn btn-outline-info btn-round btn-sm"
                                                           data-toggle="modal">View History</a>
                                                    @else
                                                        <a href="#viewHistory{{$account->id}}"
                                                           class="btn btn-outline-info btn-round btn-sm disabled"
                                                           data-toggle="modal">View History</a>
                                                    @endif
                                                </td>
                                            </tr>
                                                <?php $acSts = App\Models\BankAccount::getStatement($account->id); ?>
                                            @if(!empty($acSts))
                                                @foreach($acSts as $acSt)
                                                    <tr>
                                                        @if($acSt->bal_bd !== null && $acSt->is_reconciled === 0)
                                                            <form role="form"
                                                                  action="{{ URL::to('bankAccounts/reconcile/'.$account->id) }}"
                                                                  method="GET">
                                                                @csrf
                                                                <td>
                                                                    <h4><font
                                                                            color="#0BAEED">Ksh. {{ asMoney($acSt->bal_bd) }}</font>
                                                                    </h4>
                                                                    <h6>Bank Statement Balance</h6>
                                                                    <h6>
                                                                        <strong>for: {{ $acSt->stmt_month }}</strong>
                                                                    </h6>
                                                                </td>
                                                                <td style="border-left: 1px solid #ddd !important;">
                                                                    <!-- <h4><font color="#0BAEED">Ksh. {{ asMoney(24000) }}</font></h4>
										<h6>Xara Statement Balance</h6>
										<h6><strong>{{ date('M j, Y', strtotime($acSt->stmt_date)) }}</strong></h6> -->
                                                                    <div class="form-group">
                                                                        <label>Reconcile With&hellip;</label>
                                                                        <select name="book_account_id"
                                                                                class="form-control input-sm"
                                                                                required>
                                                                            <option value="">--- Select Account
                                                                                to Reconcile ---
                                                                            </option>
                                                                            <option value="">
                                                                                =====================================
                                                                            </option>
                                                                            @foreach($bkAccounts as $bookAc)
                                                                                <option
                                                                                    value="{{ $bookAc->id }}">{{ $bookAc->category }}
                                                                                    - {{ $bookAc->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td style="vertical-align: middle; border-left: 1px solid #ddd !important;">
                                                                    <input type="submit"
                                                                           class="btn btn-outline-secondary btn-round btn-sm"
                                                                           value="Reconcile Accounts">
                                                                    <input type="hidden" name="rec_month"
                                                                           value="{{ $acSt->stmt_month }}">
                                                                </td>
                                                            </form>
                                                    </tr>
                                                    @elseif($acSt->is_reconciled === 1)
                                                        <td colspan="3">
                                                            <h4><font
                                                                    color="#0BAEED">Ksh. {{ asMoney($acSt->bal_bd) }}</font>
                                                            </h4>
                                                            <h6>Bank Statement Balance for
                                                                <strong>{{ $acSt->stmt_month }}</strong></h6>
                                                            <h6><font color="green">THE BANK STATEMENT HAS BEEN
                                                                    RECONCILED.</font></h6>
                                                        </td>
                                                        <!-- <td style="vertical-align: middle; border-left: 1px solid #ddd !important;">
										<a href="{{ URL::to('bankAccounts/reconcile/'.$account->id) }}" class="btn btn-success btn-sm">Reconciliation History</a>
									</td> -->
                                                    @endif
                                                @endforeach
                                            @else
                                                <td colspan="1">
                                                    <h4><font color="#0BAEED">Ksh. {{ asMoney(0) }}</font></h4>
                                                    <h6>Bank Statement Balance</h6>
                                                    <h6><font color="#E74C3C">NO STATEMENT TRANSACTIONS UPLOADED
                                                            FOR LAST MONTH
                                                            YET</font></h6>
                                                </td>
                                                <td colspan="2"
                                                    style="vertical-align: middle; border-left: 1px solid #ddd !important;">
                                                    <a href="#uploadStatement{{$account->id}}"
                                                       class="btn btn-success btn-sm"
                                                       data-toggle="modal">Upload Bank Statement</a>
                                                </td>
                                            @endif
                                            </tbody>
                                        </table>
                                        <div id="uploadStatement{{$account->id}}" class="modal fade">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{url('bank/account/upload')}}" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <img src="{{asset('images/excel.gif')}}"
                                                                         style="height: 400px; width: 400px;">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h4>The following are the requirements for the bank
                                                                        statement:</h4>
                                                                    <p>
                                                                        &#45; It should be in a CSV(Comma Separated
                                                                        Values) format<br>
                                                                        &#45; The following fields should be included:
                                                                    </p>
                                                                    <div style="margin-left: 20px;">
                                                                        <p>
                                                                            &#10003; <strong>Date</strong> of
                                                                            transaction,
                                                                            format<strong>(YYYY-MM-DD)</strong>.<br>
                                                                            &#10003; <strong>Description</strong> of
                                                                            transaction.<br>
                                                                            &#10003; Transaction
                                                                            <strong>reference</strong> number (NOT
                                                                            mandatory).<br>
                                                                            &#10003; Transaction <strong>Amount</strong>
                                                                            (+ve if deposit, -ve if
                                                                            withdrawal).<br>
                                                                            &#10003; <strong>Cheque number</strong> if
                                                                            it exists.<br>
                                                                            &#10003; <font color="red"><strong>NB: The
                                                                                    file should contain a
                                                                                    header row (Containing column
                                                                                    headings)</strong></font>
                                                                        </p>
                                                                    </div>
                                                                    <hr>
                                                                    <div style="background:#E1F5FE; padding: 10px;">
                                                                        <input type="hidden" name="bnk_id"
                                                                               value="{{$account->id}}">
                                                                        <div class="form-group">
                                                                            <label for="username">Statement
                                                                                Month</label>
                                                                            <div class="right-inner-addon ">
                                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                                <input
                                                                                    class="form-control input-sm datepicker2"
                                                                                    readonly="readonly" type="text"
                                                                                    name="stmt_month"
                                                                                    id="date"
                                                                                    value="{{date('m-Y', strtotime('-1 month'))}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Bank Balance b/d</label>
                                                                            <input class="form-control input-sm"
                                                                                   type="text" name="bal_bd"
                                                                                   placeholder="Bank Balance B/D">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Upload Statement</label>
                                                                            <input type="file"
                                                                                   class="btn btn-info btn-sm"
                                                                                   name="bknStatementCSV">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button class="btn btn-sm btn-outline-warning btn-round"
                                                                    data-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-success btn-round"
                                                                    type="submit">
                                                                Upload
                                                            </button>
                                                            <a href="{{url('/')}}"
                                                               class="btn btn-sm btn-outline-secondary btn-round">
                                                                Download Template
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                    @empty
                                        <h4><font color='red'>No Bank Accounts Available!</font></h4>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addAccounts">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('bank/account/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" id="bank_name">
                        </div>
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" name="account_name" class="form-control" id="account_name">
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" name="account_number" class="form-control" id="account_number">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-round btn-outline-warning" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-sm btn-round btn-outline-success" type="submit">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
