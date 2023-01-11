@extends('layouts.main')
@section('title', 'Charge')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-activity bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Charge</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Charge</a></li>
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
                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                data-target="#addCharge">
                                Add Charge
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Calculation Method</th>
                                        <th>Payment Method</th>
                                        <th>Percentage Of</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count=1?>
                                    @forelse ($charges as $charge)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $charge->name }}</td>
                                            <td>{{ $charge->category }}</td>
                                            <td>{{ $charge->calculation_method }}</td>
                                            <td>{{ $charge->payment_method }}</td>
                                            <td>{{ $charge->percentage_of }}</td>
                                            <td>{{ $charge->amount }}</td>
                                            <td></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" align="center">
                                                <i class="feather icon-activity fa-5x text-purple"></i>
                                                <p>Add Charges</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addCharge">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/charge/store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Charge Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="loan">Loan</option>
                                <option value="saving">Saving</option>
                                <option value="share">Share</option>
                                <option value="member">member</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Charge Name</label>
                            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ old('name') }}">
                        </div>
                         <div class="form-group">
                            <label for="username">Calculation Method</label>
                          <select class="form-control" name="calculation_method" id="calculation_method">
                            <option></option>
                            <option value="flat">Flat</option>
                            <option value="percent">Percentage</option>
                             <option value="formula">Formula</option>
                          </select>
                        </div>
                         <div class="form-group">
                            <label for="username">Payment Time</label>
                          <select class="form-control" name="payment_method" id="payment_method">
                            <option></option>
                            <option value="withdrawal">Withdrawal</option>
                            <option value="transfer">Transfer</option>
                          </select>
                        </div>
                         <div class="form-group">
                            <label for="username">Percentage of</label>
                          <select class="form-control" name="percentage_of" id="percentage_of">
                            <option></option>
                            <option value="transactionAmount">Transaction Amount</option>
                            <option value="loan">Loan</option>
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Value/ Amount</label>
                            <input class="form-control numbers" placeholder="" type="text" name="amount" id="amount" value="0">
                        </div>                
                        <div class="form-group">
                            <label for="username">is Fee</label>
                            <input  type="checkbox" name="fee" id="fee" value="1">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Add Charge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
