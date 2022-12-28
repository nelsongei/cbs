@extends('layouts.main')
@section('title','Account')
@section('content')
    <style>
        label, input {
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

        div#users-contain table td, div#users-contain table th {
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
                    <i class="feather icon-plus-circle bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Chart of Account</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Chart of Account</a></li>
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
                                    data-target="#createAccount">
                                Add Account
                            </button>
                            <button class="btn btn-s"></button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>GL Account Name</th>
                                    <th>Type 1</th>
                                    <th>Category</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                ?>
                                @forelse($accounts as $account)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$account->name}}</td>
                                        <td>{{ $account->category->type->name }}</td>
                                        <td>
                                            <a href="{{ url('/account/chart/'.$account->id) }}">
                                                {{$account->category->name}}
                                            </a>
                                        </td>
                                        <td>{{$account->code}}</td>
                                        <td>
                                            @if($account->active === 1)
                                                <button class="btn btn-sm btn-outline-success btn-round">
                                                    Active
                                                </button>
                                            @else
                                            @endif
                                        </td>
                                        <td>0.0</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-success"
                                                       href="{{url('account/chart/'.$account->id)}}">View</a>
                                                    <a class="dropdown-item text-info" data-toggle="modal"
                                                       data-target="#editChart{{$account->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editChart{{$account->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('account/chart/update')}}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$account->id}}">
                                                        <div class="form-group">
                                                            <label for="category">Account Category</label>
                                                            <select class="form-control" name="category" id="category">
                                                                <option disabled>select category</option>
                                                                <option disabled>--------------------------</option>
                                                                <option value="ASSET">Asset (1000)</option>
                                                                <option value="INCOME">Income (2000)</option>
                                                                <option value="EXPENSE">Expense (3000)</option>
                                                                <option value="EQUITY">Equity (4000)</option>
                                                                <option value="LIABILITY">Liability (5000)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Account Name</label>
                                                            <input class="form-control" placeholder="" type="text"
                                                                   name="name" id="names" value="{{$account->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="code">GL Code</label>
                                                            <input class="form-control" placeholder="" type="text"
                                                                   name="code" id="codes" value="{{$account->code}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="active">Active</label>
                                                            <input type="checkbox" name="active" id="active"
                                                                   @if($account->active===1) checked @endif>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-sm btn-outline-warning btn-round"
                                                                type="button" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-success btn-round"
                                                                type="submit">
                                                            Update Account
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" align="center">
                                            <i class="fa fa-plus-square fa-5x text-success"></i>
                                            <p>Add Account</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="col-sm-12 float-right">
                                {{$accounts->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createAccount">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('account/chart/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_id">Account Category</label>
                            <select class="form-control" name="category_id" id="category_id" onclick="getCode()">
                                <option></option>
                                <option value="cnew">Create Category</option>
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}">{{$category->name.'( Start With '.$category->code.') --- '.$category->sub_type_2.' --- '.$category->type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Account Name</label>
                            <input class="form-control" placeholder="" type="text" name="name" id="name"
                                   value="{{{ old('name') }}}">
                        </div>
                        <div class="form-group">
                            <label for="code">GL Code</label>
                            <input class="form-control" placeholder="" type="text" name="code" id="code"
                                   readonly
                                   value="{{{ old('code') }}}">
                        </div>
                        <div class="form-group">
                            <label for="active">Active</label>&nbsp;&nbsp;
                            <input type="checkbox" name="active" id="active" value="1">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="dialog-form" title="Create new Account">
        <p class="validateTips">Please insert All fields.</p>
        <form action="{{url('/')}}" method="post">
            <fieldset>
                <div class="form-group">
                    <label for="type_account_id">Account Type</label>
                    <select name="type_account_id" class="form-control" id="type_account_id">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="category_name">Sub Type 1 Name <span style="color:red">*</span></label>
                    <input type="text" name="category_name" id="category_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sub_type_2">Sub Type 2 Name <span style="color:red">*</span></label>
                    <input type="text" name="sub_type_2" id="sub_type_2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="category_code">Code Start <span style="color:red">*</span></label>
                    <input type="number" name="category_code" id="category_code" value=""
                           class="form-control">
                </div>
                <input type="submit" tabindex="-1"
                       style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <link href="{{asset('jquery-ui-1.11.4.custom/jquery-ui.css')}}"/>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script>
        $(function () {
            var dialog, form,
                name = $("#category_name"),
                code = $("#category_code"),
                sub_type_2 = $("#sub_type_2"),
                type_account_id = $("#type_account_id"),
                allFields = $([]).add(name).add(code).add(sub_type_2).add(type_account_id),
                tips = $(".validateTips");

            function updateTips(t) {
                tips
                    .text(t)
                    .addClass("ui-state-highlight");
                setTimeout(function () {
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
                valid = valid && checkLength(code, "Please insert account category code!");
                if (valid) {
                    const createCategoryAccount = {
                        "name": document.getElementById('category_name').value,
                        "code": document.getElementById('category_code').value,
                        "type_account_id": document.getElementById("type_account_id").value,
                        "sub_type_2": document.getElementById("sub_type_2").value,
                        "_token": "{{csrf_token()}}"
                    }
                    $.ajax({
                        url: "{{url('account/category')}}",
                        type: "POST",
                        async: false,
                        data: createCategoryAccount,
                        success: function (s) {
                            $('#category_id').append($('<option>', {
                                value: s,
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
                height: 410,
                width: 350,
                modal: true,
                buttons: {
                    "Create": addUser,
                    Cancel: function () {
                        dialog.dialog("close");
                    }
                },
                close: function () {
                    form[0].reset();
                    allFields.removeClass("ui-state-error");
                }
            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
                addUser();
            });

            $('#category_id').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                    $("#createAccount").modal("hide");
                }

            });
        });
    </script>
    <script>
        function getCode() {
            const category = document.getElementById('category_id').value;
            $.ajax({
                type: "GET",
                url: "../account/code/"+category,
                success: function (response) {                
                    getAccountCode(response.id);
                }
            });
        }
        function getAccountCode(id)
        {
            $.ajax({
                type: "GET",
                url: "../account/category/code/"+id,
                success: function(response){
                    console.log(response);
                    document.getElementById('code').value = response
                }
            })
        }
    </script>
@endsection
