@extends('layouts.main')
@section('title','Bank Deposits')
@section('content')
    <?php
    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <style>
        .bodyrow{margin-top:30px;}
        .butsdiv{display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-around;
            padding:4px; border-bottom:1px solid;}
        .toggleBut{padding:5px; border-radius:4px !important; background-color:#f5f5f5; outline:none; border:none; }
        .activeBut1{background-color:#9eaed0;} .hide{display:none;}
        .bodyhead{ background-color:#9eaed0; margin-bottom:4px; border-radius:4px;
            display:flex; flex-direction:row; flex-wrap:wrap; justify-content:space-between;
        }
        .bodyhead div{width:80%; padding:5px; text-align:center; background-color:#9eaed0;} .bodyhead button{width:19%;}
        .panel-body{display:none;} .activeBody1{display:block;}
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
                            <a href="{--><!--{ url('/home')}}"><i class="feather icon-home"></i></a>
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
                                    data-target="#addTransactions">
                                Transact
                            </button>
                            <div class='butsdiv panel-head' >
                                <?php $p=0; foreach($bankAccs as $bankAcc){ $p++; //if($p==1){$active=1;}else{$active=0;}?>
                                <button class='toggleBut activeBut{{$p}}' lang='{{$bankAcc->id}}'><span>{{$bankAcc->bank_name}}</span></button>
                                <?php } $m=0;?>
                            </div>
                            @foreach($bankAccs as $bankAcc) <?php $m++; $bankBal=App\Models\BankAccount::bankAccBal($bankAcc->id);?>
                            <div class='bodydiv{{$bankAcc->id}} activeBody{{$m}} bodydiv panel-body'>
                                <div class='bodyhead' lang='{{$bankAcc->id}}'>
                                    <div>{{$bankAcc->bank_name}}  ||  Balance:{{asMoney($bankBal)}}</div>
                                    <button class='transactBut' lang='{{$bankAcc->bank_name}}' src='{{$bankAcc->id}}' data-toggle="modal" data-target="#addTransactions">Transact</button>
                                </div>
                                <table id="users" class="table  table-bordered  table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>From</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <!--<th></th>-->
                                        <th>Payment method</th>
                                        <th>Reference No.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; $transactions=App\Models\AccountTransaction::where("is_bank",1)->where("bank_account_id",$bankAcc->id)->get(); ?>
                                    @foreach($transactions as $transaction)
                                            <?php
                                            //$initiator=App\Models\Member::findorfail($transaction->initiated_by);
                                            ?>
                                        <tr>
                                            <td> {{ $i }}</td>
                                            <td>{{ $transaction->initiated_by }}</td>
                                            <td>{{ asMoney($transaction->transaction_amount) }}</td>
                                            <td>{{ $transaction->transaction_date }}</td>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{{ $transaction->form }}</td>
                                            <td>{{ $transaction->id*time() }}</td>
                                        </tr>
                                            <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addTransactions">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('bank/bankReconciliation/payment')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bankAcc"> Bank Account </label>
                            <?php $bankAccs = App\Models\BankAccount::all(); ?>
                            <select class="form-control" name="bankAcc" required>
                                @foreach($bankAccs as $bankAcc)
                                    <option value='{{$bankAcc->id}}'>{{$bankAcc->bank_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bankrefno"> Bank Ref. No.</label>
                            <input class="form-control" placeholder="Bank Ref no." type="text" name="bankrefno"
                                   id="bankrefno"
                                   value="{{{ old('bankrefno') }}}" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Transaction type</label><br>
                            Payments: &nbsp;&nbsp;<input type="radio" name="type" value="payment" checked>&nbsp;&nbsp;&nbsp;&nbsp;
                            Disbursal: &nbsp;&nbsp;<input type="radio" name="type" value="disbursal">
                        </div>
                        <div class="form-group">
                            <label for="payment_form"> Payment form </label>
                            <select class="form-control" name="payment_form" required>
                                <option>Cash</option>
                                <option>Cheque</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input class="form-control" placeholder="Amount" data-parsley-trigger="change focusout"
                                   data-parsley-type="number" type="number" name="amount" id="amount"
                                   value="{{{ old('amount') }}}" required>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <div class="right-inner-addon ">
                                <i class="glyphicon glyphicon-calendar"></i>
                                <input class="form-control datepicker" readonly placeholder="Date" type="text" name="date"
                                       id="date" @if(old('date')) value="{{{ date('Y-m-d') }}}"
                                       @else value="{{date('Y-m-d')}}" @endif required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                      placeholder="Insert description of the Bank Transaction." class="form-control"
                                      required>{{{ old('description') }}}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
