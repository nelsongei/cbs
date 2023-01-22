@extends('layouts.main')
@section('title','Asset Movements')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-truck bg-success"></i>
                    <div class="d-inline">
                        <h5>Assets Movements</h5>
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
                        <div class="card-body">
                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal" data-target="#moveAsset">
                                Move Asset
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Asset</th>
                                    <th>Department</th>
                                    <th>Date Moved</th>
                                    <th>No. Moved</th>
                                    <th>No. Remaining</th>
                                    <th>Maintenance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $count=1?>
                                @forelse($moves as $move)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$move->asset->asset_name}}</td>
                                        <td>{{$move->department->name}}</td>
                                        <td>{{$move->created_at}}</td>
                                        <td>{{$move->moved}}</td>
                                        <td>{{$move->remaining}}</td>
                                        <td>{{$move->maintenance}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-outline-success btn-round dropdown-toggle"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-info" data-toggle="modal"
                                                       data-target="#approve{{$move->id}}">Edit</a>
                                                    <a class="dropdown-item text-danger" data-toggle="modal"
                                                       data-target="#reject{{$move->id}}">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" align="center">
                                            <i class="fa fa-check text-info fa-5x"></i>
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
    <div class="modal fade" id="moveAsset">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('/asset/movement/asset')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="asset_id">Asset</label>
                            <select name="asset_id" class="form-control" id="asset_id" onclick="checkAsset()">
                                @foreach($assets as $asset)
                                    <option value="{{$asset->id}}">{{$asset->asset_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qty">Current Assets Count</label>
                            <input type="text" class="form-control" id="qty" name="qty" readonly>
                        </div>
                        <div class="form-group">
                            <label for="remaining">Remaining</label>
                            <input type="text" class="form-control" id="remaining" name="remaining" readonly>
                        </div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" class="form-control" id="department" name="department" readonly>
                        </div>
                        <div class="form-group">
                            <label for="department_id">Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                @forelse($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @empty
                                    <option disabled>Add Department</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">No. Assets To Be Moved</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" oninput="checkRemaining()">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" type="button" data-dismiss="modal">
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        function checkAsset() {
            var ids  = document.getElementById('asset_id').value;
            $.ajax({
                type: "GET",
                url: "../asset/check/details/"+ids,
                success: function (response) {
                    for (var i=0;i<response.length;i++)
                    {
                        document.getElementById('qty').value = response[i].purchase.quantity
                        document.getElementById('department').value = response[i].department.name
                        document.getElementById('remaining').max =response[i].purchase.quantity;
                    }
                }
            })
        }
        function checkRemaining() {
            var qty = document.getElementById('quantity').value;
            var current = document.getElementById('qty').value;
            if ((Number(current) - Number(qty))<1)
            {
                alert('Check Current Asset Amount and How many ypu need to move');
            }
            else {
                document.getElementById('remaining').value = Number(current) - Number(qty);
            }
        }
    </script>
@endsection
