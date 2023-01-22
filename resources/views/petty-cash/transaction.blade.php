@extends('layouts.main')
@section('title','Transaction')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-chess-king bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>New Transaction</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('/petty/cash')}}">Petty Cash</a></li>
                        <li class="breadcrumb-item active"><a href="#">Transaction</a></li>
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
                        <form action="{{url('/petty/transaction')}}" method="GET" data-parsley-validate>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-2">
                                        <label for="particular_id">Particulars</label>
                                        <select name="particular_id" id="particular_id" class="form-control">
                                            @foreach($particulars as $particular)
                                                <option value="{{$particular->id}}">{{$particular->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" class="form-control" id="description">
                                    </div>
                                    <input type="hidden"  class="form-control input-sm" name="qty"  value="1">
                                    <div class="form-group col-sm-2">
                                        <label for="date">Date</label>
                                        <input type="text" class="form-control datepicker" id="date" name="date">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="receipt">Receipt No</label>
                                        <input type="text" class="form-control" id="receipt" name="receipt">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                                    Add Item
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Receipt Items</h4>
                        </div>
                        <form action="{{url('/petty/petty_cash/commitTransaction')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Particular/Item</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Receipt</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($trItems != null)
                                            <?php $count = 0; $itemTotal = 0; $grandTotal = 0; ?>
                                        @foreach($trItems as $trItem)
                                                <?php
                                                $itemTotal = $trItem['quantity'] * $trItem['unit_price'];
                                                $grandTotal += $itemTotal;
                                                ?>
                                            <tr>
                                                <td>{{ $count+1 }}</td>
                                                <td>{{ $trItem['item_name'] }}</td>
                                                <td>{{ $trItem['description'] }}</td>
                                                <td>{{ $trItem['date'] }}</td>
                                                <td>{{ $trItem['receipt'] }}</td>
                                                <td>{{ $itemTotal }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{url('petty/petty_cash/remove/'.$count)}}" class="btn btn-outline-danger btn-round btn-sm"><i class="fa fa-times"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                                <?php $count++; ?>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="total">Grand Total</td>
                                            <td class="total">{{ $grandTotal }}</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <a href="{{url('/petty/cash')}}" class="btn btn-sm btn-round btn-outline-warning">
                                    Cancel
                                </a>
                                <button class="btn btn-round btn-outline-success" type="submit">
                                    Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
