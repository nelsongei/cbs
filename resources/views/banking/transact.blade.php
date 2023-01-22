@extends('layouts.main')
@section('title','Disbursal and Payments')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-chart-area bg-c-green"></i>
                    <div class="d-inline">
                        <h5>Disbursal & Payments</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Disbursal & Payments</a></li>
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
                                Add Bank Transaction Entry
                            </button>
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
                        <button class="btn btn-sm btn-outline-warning" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success" type="submit">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
