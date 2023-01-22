<?php


function asMoney($value)
{
    return number_format($value, 2);
}

?>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css">

        table {
            max-width: 100%;
            background-color: transparent;
        }

        th {
            text-align: left;
        }

        .table {
            width: 100%;
            margin-bottom: 2px;
        }

        hr {
            margin-top: 1px;
            margin-bottom: 2px;
            border: 0;
            border-top: 2px dotted #eee;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.428571429;
            color: #333;
            background-color: #fff;
        }


    </style>
</head>
<body>


<div class="row">


    <div class="col-lg-8">


        <table class="table table-bordered">

            <tr>


                <td>

                    <img src="{{asset('public/uploads/logo/'.Auth::user()->organization->logo)}}"
                         alt="{{ Auth::user()->organization->logo }}"
                         style="height: 50px;"/>

                </td>

                <td>
                    <strong>
                        {{ strtoupper(Auth::user()->organization->name)}}<br>
                    </strong>
                    {{ Auth::user()->organization->phone}}<br>
                    {{ Auth::user()->organization->email}}<br>
                    {{ Auth::user()->organization->website}}<br>
                    {{ Auth::user()->organization->address}}


                </td>


            </tr>


            <tr>

                <hr>
            </tr>


        </table>


        <table class="table table-bordered">

            <tr>


                <td>Member:</td>
                <td> {{ $saving->member->name}}</td>
            </tr>
            <tr>

                <td>Member #:</td>
                <td> {{ $saving->member->membership_no}}</td>

            </tr>
            <tr>

                <td>Account :</td>
                <td> {{ $saving->account->account_number}}</td>

            </tr>

            <tr>

                <td>Account Balance:</td>
{{--                <td> {{ asMoney(App\Models\Savingaccount::getAccountBalance($saving->savingaccount))}}</td>--}}

            </tr>


            <tr>

                <td>Branch :</td>
                <td> {{ $saving->member->branch->name}}</td>

            </tr>


            <tr>

                <hr>
            </tr>


        </table>

        <br><br>

        <table class="table table-bordered">


            <tr>

                <td><strong> Date </strong></td>
                <td><strong> Description </strong></td>
                <td><strong> Amount </strong></td>

            </tr>

            <tr>

                <td>{{ $saving->date }}</td>
                <td>{{ $saving->description }}</td>
                <td>{{ asMoney($saving->saving_amount )}}</td>


            </tr>


            <tr>

                <hr>
            </tr>


        </table>


        <br><br>

        <table class="table table-bordered">
            <tr>

                <td style="width:80px;"> Transacted By</td>
                <td>  {{$saving->transacted_by}} </td>


            </tr>


            <tr>

                <td style="width:80px;"> Served By</td>
                <td>  {{Auth::user()->firstname.' '.Auth::user()->lastname}} </td>


            </tr>


            <tr>

                <hr>


            </tr>


        </table>

        <p>Thank you for saving with us</p>


    </div>

</div>
</body>
</html>



