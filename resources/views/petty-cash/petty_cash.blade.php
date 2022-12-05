@extends('layouts.main')
@section('title','Petty Cash')
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
                    <i class="fa fa-chess-queen bg-c-orenge"></i>
                    <div class="d-inline">
                        <h5>Petty Cash</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Petty Cash</a></li>
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
                            @if($petty_account !==null)
                                <button class="btn btn-sm btn-outline-warning btn-round" data-toggle="modal"
                                        data-target="#transfer">
                                    Transfer From
                                </button>
                                <a href="{{url('petty/transaction')}}" class="btn btn-sm btn-outline-success btn-round">
                                    New Transaction
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-round" data-toggle="modal"
                                        data-target="#report">
                                    Generate Report
                                </button>
                                <table class="table table-striped table-bordered mt-2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Reference</th>
                                        <th>Spent</th>
                                        <th>Received</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $count=1;
                                        ?>
                                    @forelse($ac_transactions as $transaction)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $transaction->transaction_date }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ $transaction->ref }}</td>
                                            @if($transaction->credit_account_id == $petty_account->id)
                                                <td>{{ $transaction->transaction_amount }}</td>
                                                <td></td>
                                            @elseif($transaction->debit_account_id == $petty_account->id)
                                                <td></td>
                                                <td>{{ $transaction->transaction_amount }}</td>
                                            @endif
                                            <td>
                                                <div class="btn-group pull-right">
                                                    <button type="button"
                                                            class="btn btn-outline-success btn-round btn-sm dropdown-toggle dropdown-menu-left"
                                                            data-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Action <span
                                                            class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        role="menu">
                                                        @if($transaction->pettycount() > 0)
                                                            <li>
                                                                <a href="{{url('petty_cash/transaction/'.$transaction->id)}}">
																		<span class="glyphicon glyphicon-file"
                                                                              aria-hidden="true">&nbsp;View
                                                                        </span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                            <li>
                                                                <a href="{{ url('petty_cash/delete/'.$transaction->id) }}"
                                                                   onclick="return (confirm('Are you sure you want to delete this entry?'))">
																			<span class="glyphicon glyphicon-trash"
                                                                                  aria-hidden="true">&nbsp;Delete
                                                                            </span>
                                                                </a>
                                                            </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="modal fade" id="transfer">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ url('petty/petty_cash/addMoney') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>From:</label>
                                                        <select class="form-control input-sm selectable" name="ac_from"
                                                                style="width: 100%;" required>
                                                            <option value="">--- Select an account ---</option>
                                                            @if(count($assets) > 0)
                                                                @foreach($assets as $asset)
                                                                    <option value="{{ $asset->id }}">{{ $asset->code }}
                                                                        - {{ $asset->name }} - (Balance:
                                                                        KES. {{ asMoney(App\Models\Account::getAccountBalanceAtDate($asset, date('Y-m-d'))) }}
                                                                        )
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>To (Petty Cash): </label>
                                                        <select class="form-control input-sm selectable" name="ac_to"
                                                                style="width: 100%;" required>
                                                            <option
                                                                value="{{ $petty_account->id }}">{{ $petty_account->code }}
                                                                - {{ $petty_account->name }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Date:</label>
                                                        <input type="text" class="form-control datepicker" name="date"
                                                               style="width: 100%;" value="{{date('Y-m-d')}}" readonly
                                                               required>

                                                    </div>

                                                    <div class="form-group">
                                                        <label>Reference:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Ref No.</span>
                                                            <input type="text" class="form-control input-sm"
                                                                   name="reference" placeholder="Cheque No." required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Transfer Amount:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">KES</span>
                                                            <input type="text" class="form-control input-sm numberInput"
                                                                   name="amount" placeholder="{{ asMoney(0) }}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button"
                                                            class="btn btn-outline-warning btn-round btn-sm"
                                                            data-dismiss="modal">Cancel
                                                    </button>&emsp;
                                                    <input type="submit"
                                                           class="btn btn-outline-success btn-round btn-sm"
                                                           value="Receive Money">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card-body text-center">
                                    <h4><font color="red">NO PETTY CASH ACCOUNT AVAILABLE PLEASE CREATE ONE!!! (AS AN
                                            ASSET ACCOUNT)</font></h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
