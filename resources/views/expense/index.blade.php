@extends('layouts.main')
@section('title', 'Expenses')
@section('content')
    <style>
        .modal-lg,
        .modal-xl {
            max-width: 1500px;
        }

        label,
        input {
            display: block;
        }

        input.text {
            margin-bottom: 12px;
            width: 95%;
            padding: .4em;
        }

        fieldset {
            padding: 0;
            border: 0;
            margin-top: 25px;
        }

        h1 {
            font-size: 1.2em;
            margin: .6em 0;
        }

        div#users-contain {
            width: 350px;
            margin: 20px 0;
        }

        div#users-contain table {
            margin: 1em 0;
            border-collapse: collapse;
            width: 100%;
        }

        div#users-contain table td,
        div#users-contain table th {
            border: 1px solid #eee;
            padding: .6em 10px;
            text-align: left;
        }

        .ui-dialog .ui-state-error {
            padding: .3em;
        }

        .validateTips {
            border: 1px solid transparent;
            padding: 0.3em;
        }

        /*.ui-dialog {*/
        /*    position: fixed;*/
        /*    margin-bottom: 850px;*/
        /*}*/


        .ui-dialog-titlebar-close {
            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_444444_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
            border: medium none;
        }

        .ui-dialog-titlebar-close:hover {
            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_ffffff_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
        }
    </style>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-calculator bg-info"></i>
                    <div class="d-inline">
                        <h5>Expenses</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Expenses</a></li>
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
                            <div class="dropdown">
                                <button class="btn btn-outline-success btn-round dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    New Transaction
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#bill">Bill</a>
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#cheque">Cheque</a>
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#purchaseOrder">Purchase
                                        Order</a>
                                    <a class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#transfer">Transfer</a>
                                    <a class="dropdown-item text-info" data-toggle="modal"
                                        data-target="#supplierCredit">Supplier
                                        Credit</a>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    ?>
                                    @forelse($expenses as $expense)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $expense->particular->name }}</td>
                                            <td>{{ $expense->amount }}</td>
                                            <td>{{ $expense->description }}</td>
                                            <td>{{ $expense->date }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item text-info" data-toggle="modal"
                                                            data-target="#editChart{{ $expense->id }}">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" align="center">
                                                <i class="fa fa-file-excel fa-5x text-c-purple"></i>
                                                <p>No Expenses</p>
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
    <div class="modal fade" id="purchaseOrder">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-success">
                                <i class="fa fa-history"></i>
                                Purchase Order
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">
                                <p>Balance Due:</p>
                                <h6 class="text-dark">
                                    <b> Ksh. 1000</b>
                                    </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="">Supplier</label>
                                <select class="form-control" id="supplier_ids">
                                    <option></option>
                                    <option value="cnew">Create New</option>
                                    @foreach ($suppliers as $supplier)
                                        <option onclick="getSupplierInfo({{ $supplier->id }})" value="{{ $supplier->id }}">
                                            {{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">Purchase Order Date</label>
                                <input type="text" name="payment_date" class="form-control datepicker">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">Ship Via</label>
                                <input type="text" name="ref_no" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Category Details</label>
                            <div id="addSupplierCategoryDetails">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input class='ncheck_all_supplier' type='checkbox' onclick="select_all_supplier_category()" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Category</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteSupplierCategory">
                                        <span id='nsnums'></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="account_id" class="form-control">
                                            @foreach ($accounts as $account)
                                                <option value="">
                                                    {{ $account->name . ' --- ' . $account->category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="witholding">Witholding Rate 5%</option>
                                            <option value="reverse">Reverse Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-info mt-2 supplierCategory btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-sm mt-2 btn-sm btn-round btn-outline-danger supplierDelete"
                                type="button">
                                Remove
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="">Product & Services</label>
                            <div id="addSupplierProductService">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="checkbox" onclick="select_all_supplier()"
                                            class="check_all_supplier_service">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteSupplierService">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="excempt">Witholding Rate 5%</option>
                                            <option value="excempt">Reverce Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary supplierproduct mt-2 btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-outline-danger deleteSupplierProduct  mt-2 btn-sm btn-round"
                                type="button">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-sm btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-sm btn-round">
                            Add Purchase Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="supplierCredit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-success">
                                <i class="fa fa-history"></i>
                                Supplier Credit
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">
                                <p>Balance Due:</p>
                                <h6 class="text-dark">
                                    <b> Ksh. 1000</b>
                                    </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <form action="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="">Supplier</label>
                                <select class="form-control" id="supplier_ids">
                                    <option></option>
                                    <option value="cnew">Create New</option>
                                    @foreach ($suppliers as $supplier)
                                        <option onclick="getSupplierInfo({{ $supplier->id }})" value="{{ $supplier->id }}">
                                            {{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">Payment Date</label>
                                <input type="text" name="payment_date" class="form-control datepicker">
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="">Ref.No</label>
                                <input type="text" name="ref_no" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Category Details</label>
                            <div id="addSupplierCategoryDetails">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input class='ncheck_all_supplier' type='checkbox' onclick="select_all_supplier_category()" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Category</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteSupplierCategory">
                                        <span id='nsnums'></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="account_id" class="form-control">
                                            @foreach ($accounts as $account)
                                                <option value="">
                                                    {{ $account->name . ' --- ' . $account->category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="witholding">Witholding Rate 5%</option>
                                            <option value="reverse">Reverse Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-info mt-2 supplierCategory btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-sm mt-2 btn-sm btn-round btn-outline-danger supplierDelete"
                                type="button">
                                Remove
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="">Product & Services</label>
                            <div id="addSupplierProductService">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="checkbox" onclick="select_all_supplier()"
                                            class="check_all_supplier_service">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteSupplierService">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="excempt">Witholding Rate 5%</option>
                                            <option value="excempt">Reverce Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary supplierproduct mt-2 btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-outline-danger deleteSupplierProduct  mt-2 btn-sm btn-round"
                                type="button">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-sm btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-sm btn-round">
                            Add Supplier Credit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cheque">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-primary">
                                <i class="fa fa-history"></i>
                                Cheque no. 101
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">
                                <p>Balance Due:</p>
                                <h6 class="text-dark">
                                    <b> Ksh. 1000</b>
                                    </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="">Payee</label>
                                <select name="" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">Bank Account</label>
                                <select name="" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">Payment Date</label>
                                <input type="text" name="paymentDate" class="form-control datepicker"
                                    id="paymentDate">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="">Cheque No</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Category Details</label>
                            <div id="addChequeCategoryDetails">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input class='ncheck_all_cheque' type='checkbox'
                                            onclick="select_all_cheques()" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Category</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteChequeCategory">
                                        <span id='nsnums'></span>
                                    </div>
                                    <div class="col-sm-3">
                                        <select name="account_id" class="form-control">
                                            @foreach ($accounts as $account)
                                                <option value="">
                                                    {{ $account->name . ' --- ' . $account->category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="witholding">Witholding Rate 5%</option>
                                            <option value="reverse">Reverse Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-info mt-2 chequeCategory btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-sm mt-2 btn-sm btn-round btn-outline-danger" id="chequ"
                                type="button">
                                Remove
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="">Product & Services</label>
                            <div id="addChequeProductService">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="checkbox" onclick="select_all_Product()"
                                            class="check_all_cheque_service">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteChequeService">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="excempt">Witholding Rate 5%</option>
                                            <option value="excempt">Reverce Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary chequeproduct mt-2 btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-outline-danger deleteChequeProduct  mt-2 btn-sm btn-round"
                                type="button">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-round btn-sm" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-round btn-sm">
                            Add Cheque
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bill">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="text-primary">
                                <i class="fa fa-history"></i>
                                Bill
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <span class="float-right">
                                <p>Balance Due:</p>
                                <p>Total Tax: <span id="TotalTax">0</p>
                                <span class="text-dark" id="TotalBalance">
                                    Ksh. 1000
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select class="form-control" id="supplier_id">
                                <option></option>
                                <option value="cnew">Create New</option>
                                @foreach ($suppliers as $supplier)
                                    <option onclick="getSupplierInfo({{ $supplier->id }})" value="{{ $supplier->id }}">
                                        {{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="SupplierBioData" style="display:none">
                            <label for="">Supllier Information</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <strong class="text-c-blue">
                                        <i class="fa fa-location-arrow mr-1"></i>Address
                                    </strong>
                                    <p class="text-muted" id="supplierAddress">
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <strong class="text-success">
                                        <i class="fa fa-envelope mr-1"></i>Email
                                    </strong>
                                    <p class="text-muted" id="supplierEmail">
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <strong class="text-info">
                                        <i class="fa fa-phone mr-1"></i>Phone
                                    </strong>
                                    <p class="text-muted" id="supplierPhone">
                                    </p>
                                </div>
                                <div class="col-sm-3">
                                    <strong class="text-c-green">
                                        <i class="fa fa-server mr-1"></i>Supplier Group
                                    </strong>
                                    <p class="text-muted" id="supplierGroup">
                                    </p>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Amount Are</label>
                                    <select class="form-control" id="selectTax">
                                        <option value="exclusive">Exclusive Of TAX</option>
                                        <option value="inclusive">Inclusive Of TAX</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoice_number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Category Details</label>
                            <div id="addCategoryDetails">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input class='ncheck_all' type='checkbox' onclick="select_all()" />
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Category</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="">Total</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteCategory">
                                        <span id='nsnum'></span>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="account_id" class="form-control">
                                            @foreach ($accounts as $account)
                                                <option value="">
                                                    {{ $account->name . ' --- ' . $account->category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" min="1"
                                            oninput="getTaxCalcs(1)" id="bill_category_amount1"
                                            name="bill_category_amount[0]">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs(1)" id="tax1">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="witholding">Witholding Rate 5%</option>
                                            <option value="reverse">Reverse Charge 5%</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" readonly id="amount_total1">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-info mt-2 category btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-sm mt-2 categoryDelete btn-sm btn-round btn-outline-danger"
                                type="button">
                                Remove
                            </button>
                        </div>
                        <div class="form-group">
                            <label for="">Product & Services</label>
                            <div id="addProductService">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="checkbox" onclick="select_allProduct()" class="check_all_product">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Amount</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Tax</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="checkbox" class="deleteService">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" onclick="getTaxCalcs()">
                                            <option value="VAT16">VAT 16%</option>
                                            <option value="zeroRated">Zero Rate 0%</option>
                                            <option value="excempt">Excempt 0%</option>
                                            <option value="excempt">Witholding Rate 5%</option>
                                            <option value="excempt">Reverce Charge 5%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary product mt-2 btn-sm btn-round" type="button">
                                Add Line
                            </button>
                            <button class="btn btn-outline-danger deleteProduct  mt-2 btn-sm btn-round" type="button">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Add Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addExpense">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('journals/store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control datepicker" name="date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="particular_id">Particulars</label>
                            <select class="form-control selectable" name="particular_id" id="particular_id" required>
                                @foreach ($particulars as $particular)
                                    <option value="{{ $particular->id }}">{{ $particular->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="narration">Narration</label>
                            <select class="form-control selectable" name="narration" id="narration" required>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">
                                        {{ $member->firstname . ' ' . $member->lastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn-sm btn btn-round btn-outline-warning" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn-sm btn btn-round btn-outline-success" type="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="dialog-form" title="Create new Supplier">
        <p class="validateTips">Please insert All fields.</p>
        <form action="{{ url('/') }}" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="supplier_name">Supplier Name <span style="color:red">*</span></label>
                    <input type="text" name="supplier_name" id="supplier_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email <span style="color:red">*</span></label>
                    <input type="email" name="email" id="email" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone <span style="color:red">*</span></label>
                    <input type="text" name="phone" id="phone" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Address <span style="color:red">*</span></label>
                    <input type="text" name="address" id="address" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="supplier_group">Supplier Group <span style="color:red">*</span></label>
                    <select name="supplier_group" id="supplier_group" class="form-control">
                        <option>Electronics</option>
                        <option>Office Stationary</option>
                        <option>Furniture</option>
                    </select>
                </div>
                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <link href="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.css') }}" />
    <script src="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
    <script>
        var i = 2;
        $(".supplierCategory").click(function() {
            count = $("#addSupplierCategoryDetails .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2'>" +
                "<input type='checkbox' class='deleteSupplierCategory'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2' id='account_name" + (i + 1) +
                "'><select onclick='getChequeAccounts(i)' class='form-control' id='name" + (i + 1) +
                "' name='name[" + (
                    i - 1) + "]'>" +
                "<option></option>" +
                "</select>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'><input type='text' class='form-control' id='description" + i +
                "' name='description[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'><input type='text' class='form-control' id='amount" + i +
                "' name='amount[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select id='tax" + i + "' name='tax[" + (i - 1) +
                "]' onclick='getTaxCalcs()' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "</div>";
            $("#addSupplierCategoryDetails").append(data);
            i++;
        });

        function getChequeAccounts(i) {
            $.ajax({
                type: "GET",
                url: "expenses/accounts",
                success: function(response) {
                    var output = '<select class="form-control">';
                    for (let k = 0; k < response.accounts.length; k++) {
                        output += '<option value="' + response.accounts[k].id + '">' + response.accounts[k]
                            .name + '</option> ';
                    }
                    output += '</select>';
                    document.getElementById('account_name' + i).innerHTML = output;
                }
            })
        }
        $(".supplierDelete").click(function() {
            if ($('.deleteSupplierCategory:checkbox:checked').length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $('.deleteSupplierCategory:checkbox:checked').parents("#addSupplierCategoryDetails .row").remove();
                    $('.ncheck_all_supplier').prop("checked", false);
                } else {
                    $('.ncheck_all_supplier').prop("checked", false);
                    $('.deleteSupplierCategory').prop("checked", false);
                }

            }
        });

        function select_all_supplier_category() {
            $('input[class=deleteSupplierCategory]:checkbox').each(function() {
                if ($('input[class=ncheck_all_supplier]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };

        function check() {
            obj = $('#addSupplierCategoryDetails .row').find('span');
            $.each(obj, function(key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }
    </script>
    <script>
        var i = 2;
        $(".supplierproduct").click(function() {
            count = $("#addSupplierProductService .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='checkbox' class='deleteSupplierService'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select name='tax' onclick='getTaxCalcs()' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "</div>";
            $("#addSupplierProductService").append(data);
            i++;
        });

        function select_all_supplier() {
            $('input[class=deleteSupplierService]:checkbox').each(function() {
                if ($('input[class=check_all_supplier_service]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };
        $(".deleteSupplierProduct").click(function() {
            if ($(".deleteSupplierService:checkbox:checked").length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $(".deleteSupplierService:checkbox:checked").parents("#addSupplierProductService .row").remove();
                    $(".check_all_supplier_service").prop("checked", false);
                } else {
                    $(".check_all_supplier_service").prop("checked", false);
                    $(".deleteSupplierService").prop("checked", false);
                }
            }
        })
    </script>
    <script>
        var i = 2;
        $(".chequeproduct").click(function() {
            count = $("#addChequeProductService .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='checkbox' class='deleteChequeService'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select name='tax' onclick='getTaxCalcs()' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "</div>";
            $("#addChequeProductService").append(data);
            i++;
        });

        function select_all_Product() {
            $('input[class=deleteChequeService]:checkbox').each(function() {
                if ($('input[class=check_all_cheque_service]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };
        $(".deleteChequeProduct").click(function() {
            if ($(".deleteChequeService:checkbox:checked").length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $(".deleteChequeService:checkbox:checked").parents("#addChequeProductService .row").remove();
                    $(".check_all_cheque_service").prop("checked", false);
                } else {
                    $(".check_all_cheque_service").prop("checked", false);
                    $(".deleteChequeService").prop("checked", false);
                }
            }
        })
    </script>
    <script>
        function getTaxCalcs(i) {
            var tax = document.getElementById('selectTax').value;
            var amount = document.getElementById('bill_category_amount' + i).value;
            var taxType = document.getElementById("tax" + i).value;
            if (tax == 'exclusive') {
                if (taxType == 'VAT16') {
                    document.getElementById("amount_total" + i).value = Math.floor(amount) + (0.16 * amount);
                }
                if (taxType == 'zeroRated') {
                    document.getElementById("amount_total" + i).value = amount;
                }
                if (taxType == 'excempt') {
                    document.getElementById("amount_total" + i).value = amount;
                }
                if (taxType == 'witholding') {
                    document.getElementById("amount_total" + i).value = Math.floor(amount) + (0.05 * amount);
                }
                var amountColumns
            }
            if (tax == 'inclusive') {
                if (taxType == 'VAT16') {
                    document.getElementById("amount_total" + i).value = Math.floor(amount) - (0.16 * amount)

                }
                if (taxType == 'zeroRated') {
                    document.getElementById("amount_total" + i).value = amount;
                }
                if (taxType == 'excempt') {
                    document.getElementById("amount_total" + i).value = amount;
                }
                if (taxType == 'witholding') {
                    document.getElementById("amount_total" + i).value = Math.floor(amount) - (0.05 * amount)
                }
            }
            var result = 0;
            var daa = document.querySelector("#addCategoryDetails .row");
            count = $("#addCategoryDetails .row").length;
            console.log(count);
            for (var t = 1; t < count; t++) {
                console.log(daa[1])
                // let amo = document.getElementById("amount_total" +i).value;
                //console.log(parseFloat(amo));
                // console.log(result+=parseFloat(amo));
            }
        }
    </script>
    <script>
        var i = 2;
        $(".chequeCategory").click(function() {
            count = $("#addChequeCategoryDetails .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2'>" +
                "<input type='checkbox' class='deleteChequeCategory'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2' id='account_name" + (i + 1) +
                "'><select onclick='getChequeAccounts(i)' class='form-control' id='name" + (i + 1) +
                "' name='name[" + (
                    i - 1) + "]'>" +
                "<option></option>" +
                "</select>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'><input type='text' class='form-control' id='description" + i +
                "' name='description[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'><input type='text' class='form-control' id='amount" + i +
                "' name='amount[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select id='tax" + i + "' name='tax[" + (i - 1) +
                "]' onclick='getTaxCalcs()' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "</div>";
            $("#addChequeCategoryDetails").append(data);
            i++;
        });

        function getChequeAccounts(i) {
            $.ajax({
                type: "GET",
                url: "expenses/accounts",
                success: function(response) {
                    var output = '<select class="form-control">';
                    for (let k = 0; k < response.accounts.length; k++) {
                        output += '<option value="' + response.accounts[k].id + '">' + response.accounts[k]
                            .name + '</option> ';
                    }
                    output += '</select>';
                    document.getElementById('account_name' + i).innerHTML = output;
                }
            })
        }
        $("#chequ").click(function() {
            if ($('.deleteChequeCategory:checkbox:checked').length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $('.deleteChequeCategory:checkbox:checked').parents("#addChequeCategoryDetails .row").remove();
                    $('.ncheck_all_cheque').prop("checked", false);
                } else {
                    $('.ncheck_all_cheque').prop("checked", false);
                    $('.deleteChequeCategory').prop("checked", false);
                }

            }
        });

        function select_all_cheques() {
            $('input[class=deleteChequeCategory]:checkbox').each(function() {
                if ($('input[class=ncheck_all_cheque]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };

        function check() {
            obj = $('#addChequeCategoryDetails .row').find('span');
            $.each(obj, function(key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }
    </script>
    <script>
        var i = 2;
        $(".product").click(function() {
            count = $("#addProductService .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='checkbox' class='deleteService'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-3 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='text' class='form-control'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select name='tax' onclick='getTaxCalcs()' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "</div>";
            $("#addProductService").append(data);
            i++;
        });

        function select_allProduct() {
            $('input[class=deleteService]:checkbox').each(function() {
                if ($('input[class=check_all_product]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };
        $(".deleteProduct").click(function() {
            if ($(".deleteService:checkbox:checked").length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $(".deleteService:checkbox:checked").parents("#addProductService .row").remove();
                    $(".check_all_product").prop("checked", false);
                } else {
                    $(".check_all_product").prop("checked", false);
                    $(".deleteService").prop("checked", false);
                }
            }
        })
    </script>
    <script>
        var i = 2;
        $(".category").click(function() {
            count = $("#addCategoryDetails .row").length;
            var data = "<div class='row'>" +
                "<div class='col-sm-2'>" +
                "<input type='checkbox' class='deleteCategory'>" +
                "</div>" +
                "<div class='col-sm-2 mt-2' id='account_name" + (i + 1) +
                "'><select onclick='getAccounts(i)' class='form-control' id='name" + (i + 1) + "' name='name[" + (
                    i - 1) + "]'>" +
                "<option></option>" +
                "</select>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'><input type='text' class='form-control' id='description" + i +
                "' name='description[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'><input type='number' min='1' oninput='getTaxCalcs(" + (i) +
                ")' class='form-control' id='bill_category_amount" + i +
                "' name='bill_category_amount[" + (i - 1) + "]'></div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<select id='tax" + i + "' name='tax[" + (i - 1) +
                "]' onclick='getTaxCalcs(" + (i) + ")' class='form-control'>" +
                "<option value='VAT16'>VAT 16%</option>" +
                "<option value='zeroRated'>Zero Rate 0%</option>" +
                "<option value='excempt'>Excempt 0%</option>" +
                "<option value='witholding'>Witholding Rate 5%</option>" +
                "<option value='reverse'>Reverse Charge 5%</option>" +
                "</select>" +
                "</div>" +
                "<div class='col-sm-2 mt-2'>" +
                "<input type='text' readonly class='form-control' name='amount_total" + i + "' id='amount_total" +
                i + "'>"
            "</div>"
            "</div>";
            $("#addCategoryDetails").append(data);
            i++;
        });

        function getAccounts(i) {
            $.ajax({
                type: "GET",
                url: "expenses/accounts",
                success: function(response) {
                    var output = '<select class="form-control">';
                    for (let k = 0; k < response.accounts.length; k++) {
                        output += '<option value="' + response.accounts[k].id + '">' + response.accounts[k]
                            .name + '</option> ';
                    }
                    output += '</select>';
                    document.getElementById('account_name' + i).innerHTML = output;
                }
            })
        }
        $(".categoryDelete").click(function() {
            if ($('.deleteCategory:checkbox:checked').length > 0) {
                if (window.confirm("Are you sure you want to delete")) {
                    $('.deleteCategory:checkbox:checked').parents("#addCategoryDetails .row").remove();
                    $('.ncheck_all').prop("checked", false);
                } else {
                    $('.ncheck_all').prop("checked", false);
                    $('.deleteCategory').prop("checked", false);
                }

            }
        });

        function select_all() {
            $('input[class=deleteCategory]:checkbox').each(function() {
                if ($('input[class=ncheck_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        };

        function check() {
            obj = $('#addCategoryDetails .row').find('span');
            $.each(obj, function(key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }
    </script>
    <script>
        $(function() {
            var dialog, form,
                name = $("#supplier_name"),
                email = $("#email"),
                phone = $("#phone"),
                address = $("#address"),
                group = $("#supplier_group"),
                allFields = $([]).add(name).add(email).add(phone).add(address).add(group),
                tips = $(".validateTips");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function() {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0 || o.val() == '') {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function checkRegexp(o, regexp, n) {
                if (!(regexp.test(o.val()))) {
                    o.addClass("ui-state-error");
                    updateTips(n);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");
                valid = valid && checkLength(name, "Please insert category name!");
                valid = valid && checkLength(email, "Please insert Email Account!");
                valid = valid && checkLength(phone, "Please insert Phone!");
                valid = valid && checkLength(address, "Please insert address !");
                valid = valid && checkLength(group, "Please insert Supplier Group !");
                if (valid) {
                    const createCategoryAccount = {
                        "name": document.getElementById('supplier_name').value,
                        "email": document.getElementById('email').value,
                        "phone": document.getElementById('phone').value,
                        "address": document.getElementById('address').value,
                        "group": document.getElementById('supplier_group').value,
                        "_token": "{{ csrf_token() }}"
                    }
                    $.ajax({
                        url: "{{ url('suppliers/storeSupplier') }}",
                        type: "POST",
                        async: false,
                        data: createCategoryAccount,
                        success: function(s) {
                            //  console.log(s.supplier_name);
                            $('#supplier_id').append($('<option>', {
                                value: s.id,
                                text: name.val(),
                                selected: true
                            }));
                            $('#supplier_ids').append($('<option>', {
                                value: s.id,
                                text: name.val(),
                                selected: true
                            }));
                        }
                    });

                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 610,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function() {
                        dialog.dialog("close");
                    }
                },
                close: function() {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                addUser();
            });

            $('#supplier_id').change(function() {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                    $("#bill").modal("hide");
                }

            });
            $('#supplier_ids').change(function() {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                    $("#supplierCredit").modal("hide");
                }

            });
        });
    </script>
    <script>
        function getSupplierInfo(id) {
            $.ajax({
                type: "GET",
                url: "suppliers/" + id,
                success: function(response) {
                    if (response) {
                        $("#SupplierBioData").show();
                        document.getElementById("supplierAddress").innerText = response.address
                        document.getElementById("supplierEmail").innerText = response.email
                        document.getElementById("supplierPhone").innerText = response.phone
                        document.getElementById("supplierGroup").innerText = response.supplier_group
                    } else {
                        $("#SupplierBioData").hide();
                    }
                }
            })
        }
    </script>
@endsection
