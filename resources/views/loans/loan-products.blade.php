@extends('layouts.main')
@section('title', 'Loan Products')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Loan Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Loan Products</a></li>
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
                                data-target="#loanProduct">
                                Add Product
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Short Name</th>
                                        <th>Formula</th>
                                        <th>Amortization</th>
                                        <th>Interest Rate</th>
                                        <th>Period</th>
                                        <th>Currency</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    ?>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->short_name }}</td>
                                            <td>{{ $product->formula }}</td>
                                            <td>{{ $product->amortization }}</td>
                                            <td>{{ $product->interest_rate }} % Monthly</td>
                                            <td>{{ $product->period }} (Months)</td>
                                            <td>{{ $product->currency->name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item text-info" data-toggle="modal"
                                                            data-target="#editChart{{ $product->id }}">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" align="center">
                                                <i class="fa fa-magnet fa-5x text-success"></i>
                                                <p>Add Loan Products</p>
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
    <div class="modal fade" id="loanProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('loan/product/store') }}" method="post">
                    @csrf
                    <div id="page1">
                        <div class="modal-header">Loan Product Details</div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" name="short_name" class="form-control" id="short_name">
                            </div>
                            <div class="form-group">
                                <label for="currency_id">Currency</label>
                                <select name="currency_id" class="form-control" id="currency_id">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">
                                            {{ $currency->name . '---' . $currency->shortname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="interest_rate">Interest Rate (Monthly)</label>
                                <input type="text" name="interest_rate" class="form-control" id="interest_rate">
                            </div>
                            <div class="form-group">
                                <label for="period">Period Months</label>
                                <input type="text" name="period" class="form-control" id="period">
                            </div>
                            <div class="form-group">
                                <label for="formula">Interest Formula</label>
                                <select class="form-control" id="formula" name="formula" required>
                                    <option value="SL"> Straight Line (SL)</option>
                                    <option value="RB"> Reducing Balance (RB)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amortization">Amortization Method</label>
                                <select class="form-control" name="amortization" id="amortization" required>
                                    <option value="EI"> Equal Instalments</option>
                                    <option value="EP"> Equal Principals</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="membership_duration">Duration For Membership to be eligible</label>
                                <input type="text" name="membership_duration" class="form-control"
                                    id="membership_duration">
                            </div>
                            <div class="form-group">
                                <label for="auto_loan_limit">Auto Loan Limit</label>
                                <input type="number" name="auto_loan_limit" class="form-control" id="auto_loan_limit">
                            </div>
                            <div class="form-group">
                                <label for="application_form">Application Form</label>
                                <select class="form-control" name="application_form" id="application_form" required>
                                    <option value="Loan Application Form"> Loan Application Form</option>
                                    <option value="Quick Advance Application Form"> Quick Advance Application Form
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" data-dismiss="modal">
                                Close
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="button" onclick="nexts(1)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page2" style="display: none">
                        <div class="modal-header">Assets</div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cash_account">Cash Account</label>
                                <select name="cash_account" class="form-control" id="cash_account">
                                    @foreach ($accounts as $account)
                                        @if ($account->category->name == 'Assets' || $account->category->name == 'Asset')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="portfolio_account">Portfolio Account</label>
                                <select name="portfolio_account" class="form-control" id="portfolio_account">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Assets' || $account->category->name == 'Asset')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" onclick="nexts(2)">
                                Previous
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="button" onclick="nexts(3)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page3" style="display: none">
                        <div class="modal-header">Income</div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="loan_interest">Interest Account</label>
                                <select name="loan_interest" class="form-control" id="loan_interest">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Income')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loan_fees">Fee Account</label>
                                <select name="loan_fees" class="form-control" id="loan_fees">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Income')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loan_penalty">Penalties Account</label>
                                <select name="loan_penalty" class="form-control" id="loan_penalty">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Income')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" onclick="nexts(4)">
                                Previous
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="button" onclick="nexts(5)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page4" style="display: none">
                        <div class="modal-header">Expenses & Liability</div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="loan_write_off">Losses Written Off</label>
                                <select name="loan_write_off" class="form-control" id="loan_write_off">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Expense'||$account->category->type->name=='Expense')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loan_overpayment">Loan Over payments</label>
                                <select name="loan_overpayment" class="form-control" id="loan_overpayment">
                                    @foreach ($accounts as $account)
                                    @if ($account->category->name == 'Liability' ||$account->category->name =='Liabilities')
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" onclick="nexts(6)">
                                Previous
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function nexts(id) {
            if (id === 1) {
                $("#page1").hide()
                $("#page2").show()
                $("#page3").hide()
                $("#page4").hide()
            }
            if (id === 2) {
                $("#page1").show()
                $("#page2").hide()
                $("#page3").hide()
                $("#page4").hide()
            }
            if (id === 3) {
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").show()
                $("#page4").hide()
            }
            if (id === 4) {
                $("#page1").hide()
                $("#page2").show()
                $("#page3").hide()
                $("#page4").hide()
            }
            if (id === 5) {
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").hide()
                $("#page4").show()
            }
            if (id === 6) {
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").show()
                $("#page4").hide()
            }
        }
    </script>
@endsection
