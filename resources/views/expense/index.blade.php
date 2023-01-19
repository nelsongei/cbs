@extends('layouts.main')
@section('title', 'Expenses')
@section('content')
    <style>
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
            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
            border: medium none;
        }

        .ui-dialog-titlebar-close:hover {
            background: url("{{ asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png') }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
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
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#bill">Cheque</a>
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#bill">Transfer</a>
                                    <a class="dropdown-item text-info" data-toggle="modal" data-target="#bill">Supplier
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
                                <strong class="text-dark">
                                    Ksh. 1000
                                </strong>
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
                        <div class="form-group">
                            <label for="">Category Details</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Description</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Amount</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Tax</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Product & Services</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Description</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Amount</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label>Tax</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
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
        $(function() {
            var dialog, form,
                name = $("#supplier_name"),
                email = $("#email"),
                phone = $("#phone"),
                address = $("#address"),
                group = $("#supplier_group"),
                // sub_type_2 = $("#sub_type_2"),
                // type_account_id = $("#type_account_id"),
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
