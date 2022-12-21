@extends('layouts.main')
@section('title','Saving Products')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-target bg-c-yellow"></i>
                    <div class="d-inline">
                        <h5>Saving Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Saving Products</a></li>
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
                            <button class="btn btn-sm btn-round btn-outline-primary" data-toggle="modal"
                                    data-target="#addProduct">
                                Add Product
                            </button>
                            <table class="table table-striped table-bordered mt-2" id="table-savings">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Shortname</th>
                                    <th>Currency</th>
                                    <th>Opening Balance</th>
                                    <th>Type</th>
                                    <th>Interest Rate</th>
                                    <th>Min Amount</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = 1 ?>
                                @forelse($savings as $saving)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>
                                            <a href="{{url('/saving/product/'.$saving->id)}}">
                                                {{$saving->name}}
                                            </a>
                                        </td>
                                        <td>{{$saving->shortname}}</td>
                                        <td>{{$saving->currency->name}}</td>
                                        <td>{{$saving->opening_balance}}</td>
                                        <td>{{$saving->type}}</td>
                                        <td>{{$saving->interest_rate}}</td>
                                        <td>{{$saving->min_amount}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" data-toggle="modal"
                                                       data-target="#edit{{$saving->id}}">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit{{$saving->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('saving/update/product')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$saving->id}}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">Product Name</label>
                                                            <input type="text" id="name" name="name"
                                                                   class="form-control"
                                                                   value="{{$saving->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shortname">Product Shortname</label>
                                                            <input type="text" id="shortname" name="shortname"
                                                                   class="form-control" readonly
                                                                   value="{{$saving->shortname}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="currency_id">Currency</label>
                                                            <input type="text" id="currency_id" name="currency_id"
                                                                   class="form-control" readonly
                                                                   value="{{$saving->currency->name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="opening_balance">Account Opening Balance</label>
                                                            <input type="number" id="opening_balance"
                                                                   name="opening_balance" class="form-control"
                                                                   min="0" value="{{$saving->opening_balance}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="interest_rate">Interest Rate</label>
                                                            <input type="text" id="interest_rate" name="interest_rate"
                                                                   class="form-control"
                                                                   value="{{$saving->interest_rate}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="type">Type</label>
                                                            <select name="type" class="form-control" id="type">
                                                                <option>FOSA</option>
                                                                <option>BOSA</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="min_amount">Min Amount</label>
                                                            <input type="number" id="min_amount" name="min_amount"
                                                                   class="form-control" min="0"
                                                                   value="{{$saving->min_amount}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="is_special">Is Special</label>
                                                            <input type="checkbox" id="is_special" name="is_special"
                                                                   class="form-control"
                                                                   min="0" {{$saving->is_special ==1?'checked':''}}>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-sm btn-round btn-outline-warning"
                                                                data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button class="btn btn-sm btn-round btn-outline-success"
                                                                type="submit">
                                                            Update Product
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" align="center">
                                            <i class="fa fa-tag fa-5x text-warning"></i>
                                            <p>No Data</p>
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
    <div class="modal fade" id="addProduct">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{url('saving/store/products')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Product Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="shortname">Product Shortname</label>
                                <input type="text" id="shortname" name="shortname" class="form-control">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="currency_id">Currency</label>
                                <select name="currency_id" class="form-control" id="currency_id">
                                    @forelse($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @empty
                                        <option disabled>Add Currency</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="opening_balance">Account Opening Balance</label>
                                <input type="number" id="opening_balance" name="opening_balance" class="form-control"
                                       min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="cash_account_id">Cash Transaction Account</label>
                                <select name="cash_account_id" class="form-control" id="cash_account_id">
                                    @forelse($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @empty
                                        <option disabled>Create Account</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="bank_account_id">Bank Transaction Account</label>
                                <select name="bank_account_id" class="form-control" id="bank_account_id">
                                    @forelse($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @empty
                                        <option disabled>Create Account</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="saving_control_account_id">Saving Control Account</label>
                                <select name="saving_control_account_id" class="form-control" id="saving_control_account_id">
                                    @forelse($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @empty
                                        <option disabled>Create Account</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="fee_income_account_id">Fee Income Account</label>
                                <select name="fee_income_account_id" class="form-control" id="fee_income_account_id">
                                    @forelse($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @empty
                                        <option disabled>Create Account</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="interest_rate">Interest Rate</label>
                                <input type="text" id="interest_rate" name="interest_rate" class="form-control">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" id="type">
                                    <option>FOSA</option>
                                    <option>BOSA</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="calculate">Calculate Interest As</label>
                                <select name="calculate" class="form-control" id="calculate">
                                    <option value="cp">Compounding</option>
                                    <option value="sl">Straight</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="min_amount">Min Amount</label>
                                <input type="number" id="min_amount" name="min_amount" class="form-control" min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="is_special">Is Special</label>
                                <input type="checkbox" id="is_special" name="is_special" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-round btn-outline-warning" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-round btn-outline-success" type="submit">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
