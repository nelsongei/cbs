<?php

function asMoney($value)
{
    return number_format($value, 2);
}

?>
<html>

<head>
    <style>
                @page {
            margin: 90px 30px 65px 30px;
        }

        .header {
            position: fixed;
            left: 0px;
            top: -85px;
            right: 0px;
            height: 80px;
            text-align: center;
        }

        .footer {
            position: fixed;
            left: 0px;
            bottom: -60px;
            right: 0px;
            height: 50px;
        }

        .footer .page:after {
            content: counter(page, upper-roman);
        }

        .content {
            margin-top: 0px;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        .topdivrow {
            width: 100%;
        }

        .topdivrow div {
            text-align: center;
            margin: 0 auto;
        }

        .headerrow {
            text-align: center;
        }

        .onerow {
            padding: 12px 2px;
        }

        .subspans {
            text-align: center;
        }

        .subspans span {}

        .onerowtable {
            margin: 0 auto;
        }

        .spandiv {
            display: inline-block;
        }

        .bottomdiv {
            text-align: center;
        }

        .spandiv2 {
            padding-left: 18px;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <img src="{{ asset('images/logo.jpg') }}" alt="{{ $organization->logo }}" style="height: 50px;" />
                </td>
                <td>
                    <strong>
                        {{ strtoupper($organization->name)}}<br>
                    </strong>
                    {{ $organization->phone}} |
                    {{ $organization->email}} |
                    {{ $organization->website}}<br>
                    {{ $organization->address}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <hr>
            </tr>
        </table>
    </div>
    <div class='onerow headerrow'>
        <span><u>LOAN ARREARS REPORT ({{ $loan_product->name }})</u></span>
    </div><br>
    <div class='onerow'>
        <table class="table table-bordered onerowtable">
            <tr>
                <td><b>Member</r>
                </td>
                <td><b>Loan amount</b></td>
                <td><b>Date disbursed</b></td>
                <td><b>Interest arrears</b></td>
                <td><b>Total arrears</b></td>
            </tr>
            <?php $total_tarrears=0; $totalInt_arrears=0;
                foreach($loan_accs as $acc){
                    $member=Member::find($acc->member_id);
                    $tarrears=Loantransaction::getAmountUnpaid($acc);  
                    $int_arrears=Loanrepayment::getInterestUnpaid($acc);  
                    $disbursed=$acc->amount_disbursed+$acc->top_up_amount; $totalIntAmount=Loanaccount::getTotalInterest($acc); 
                    $loan_amount=$disbursed+$totalIntAmount;
                    if($tarrears>0){$total_tarrears+=(int)$tarrears; $totalInt_arrears+=$int_arrears; 
                    ?>
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ asMoney($loan_amount) }}</td>
                <td>{{ $acc->date_disbursed }}</td>
                <td>{{ asMoney($int_arrears) }}</td>
                <td>{{ asMoney($tarrears) }}</td>
            </tr>
            <?php } }?>
            <tr>
                <td colspan="3" style="text-align:center;">Total</td>
                <td>{{ asMoney($totalInt_arrears) }}</td>
                <td>{{ asMoney($total_tarrears) }}</td>
            </tr>
        </table>
    </div>

</body>

</html>
