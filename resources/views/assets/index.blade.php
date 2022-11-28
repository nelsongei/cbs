@extends('layouts.main')
@section('title','Assets')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-box bg-info"></i>
                    <div class="d-inline">
                        <h5>Assets</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Assets</a></li>
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
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#assets" class="nav-link active" data-toggle="tab">
                                        Assets
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#suppliers" class="nav-link" data-toggle="tab">
                                        Suppliers
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="assets" class="tab-pane active">
                                    <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addAsset">
                                        Add Asset
                                    </button>
                                </div>
                                <div id="suppliers" class="tab-pane">
                                    <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#addSupplier">
                                        Add Supplier
                                    </button>
                                    <table class="table table-bordered table-striped mt-2">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Supplier Group</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $count=1;
                                        ?>
                                        @forelse($suppliers as $supplier)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$supplier->supplier_name}}</td>
                                                <td>{{$supplier->email}}</td>
                                                <td>{{$supplier->phone}}</td>
                                                <td>{{$supplier->address}}</td>
                                                <td>{{$supplier->supplier_group}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item text-info" data-toggle="modal" data-target="#approve{{$supplier->id}}">Edit</a>
                                                            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#reject{{$supplier->id}}">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" align="center">
                                                    <i class="fa fa-users fa-5x text-success"></i>
                                                    <p>Add Supplier</p>
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
        </div>
    </div>
    <div class="modal fade" id="addAsset">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div id="page1">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="asset_name">Asset Name</label>
                                <input type="text" name="asset_name" id="asset_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="asset_category_id">Category</label>
                                <select name="asset_category_id" id="asset_category_id" class="form-control">
                                    @forelse($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                    @empty
                                        <option disabled>Add Category</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control">
                                    @forelse($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @empty
                                        <option disabled>Add Supplier</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="asset_serial_no">Asset Serial Number</label>
                                <input type="text" name="asset_serial_no" id="asset_serial_no" class="form-control">
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="department_id">Department</label>--}}
{{--                                <select name="department_id" id="department_id" class="form-control">--}}
{{--                                    @forelse($departments as $department)--}}
{{--                                        <option value="{{$department->id}}">{{$department->name}}</option>--}}
{{--                                    @empty--}}
{{--                                        <option disabled>Add Supplier</option>--}}
{{--                                    @endforelse--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="location">Location</label>--}}
{{--                                <input type="text" name="location" id="location" class="form-control">--}}
{{--                            </div>--}}
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                                Close
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" onclick="nextx(1)" type="button">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page2" style="display: none">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="receipt_no">Receipt No</label>
                                <input type="text" name="receipt_no" id="receipt_no" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount Per Unit</label>
                                <input type="text" name="amount" id="amount" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="text" name="purchase_date" id="purchase_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="purchase_date">Total Amount</label>
                                <input type="text" name="purchase_date" id="purchase_date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" onclick="nextx(2)" type="button">
                                Previous
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round"  type="submit">
                                Add Asset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addSupplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('/suppliers/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="supplier_name">Supplier Full Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="form-group">
                            <label for="supplier_group">Supplier Group</label>
                            <select class="form-control" id="supplier_group" name="supplier_group">
                                <option>Electronics</option>
                                <option>Furniture</option>
                                <option>Office Stationary</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal" type="button">
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
    <script>
        function nextx(id) {
            if (id===1)
            {
                $("#page1").hide();
                $("#page2").show();
            }
            if (id===2)
            {
                $("#page1").show();
                $("#page2").hide();
            }
        }
    </script>
@endsection
