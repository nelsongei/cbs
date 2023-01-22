@extends('layouts.main')
@section('title','Saving Accounts')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-target bg-c-green"></i>
                    <div class="d-inline">
                        <h5>Saving Accounts</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Saving Accounts</a></li>
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
                            <button class="btn btn-sm btn-outline-primary btn-round" data-toggle="modal"
                                    data-target="#addSaving">
                                Add Saving Account
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member</th>
                                    <th>Saving Product</th>
                                    <th>Account Number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count = 1 ?>
                                @forelse($accounts as $account)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>
                                            <a href="{{url('saving/account/view/'.$account->id)}}">
                                                {{$account->member->firstname.' '.$account->member->lastname}}
                                            </a>
                                        </td>
                                        <td>{{$account->product->name}}</td>
                                        <td>{{$account->account_number}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-success"
                                                       href="{{url('saving/account/view/'.$account->id)}}">View</a>
                                                    <a class="dropdown-item text-info" data-toggle="modal"
                                                       data-target="#editAccount{{$account->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editAccount{{$account->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{url('saving/accounts/update')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$account->id}}">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="member_id2">Member</label>
                                                            <input type="text" id="member_id2" name="member_id"
                                                                   value="{{$account->member->firstname.' '.$account->member->lastname}}"
                                                                   class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="saving_product_id2">Saving Product</label>
                                                            <input type="text" id="saving_product_id2"
                                                                   name="saving_product_id"
                                                                   value="{{$account->product->name}}"
                                                                   class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="account_nos">Account</label>
                                                            <input type="text" name="account_no" id="account_nos"
                                                                   class="form-control"
                                                                   value="{{$account->account_number}}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-outline-warning btn-round"
                                                                data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button class="btn btn-outline-success btn-round" type="submit">
                                                            Update Account
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" align="center">
                                            <i class="fa fa-file fa-5x text-c-blue"></i>
                                            <p>Add Saving Account</p>
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
    <div class="modal fade" id="addSaving">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="member_id">Member</label>
                            <select name="member_id" id="member_id" class="form-control" onclick="getAccount()">
                                @foreach($members as $member)
                                    <option
                                        value="{{$member->id}}">{{$member->firstname.' '.$member->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="saving_product_id">Saving Product</label>
                            <select name="saving_product_id" id="saving_product_id" class="form-control"
                                    onclick="getAccount()">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="account" style="display: none">
                            <div class="form-group">
                                <label for="account_no">Account</label>
                                <input type="text" name="account_no" id="account_no" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-round" type="submit">
                            Add Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function getAccount() {
            const account = {
                member_id: document.getElementById('member_id').value,
                saving_product_id: document.getElementById('saving_product_id').value,
            }
            $.ajax({
                type: "GET",
                url: "getAccountNo",
                data: account,
                success: function (response) {
                    $("#account").show();
                    document.getElementById('account_no').value = response;
                }
            });
        }
    </script>
@endsection
