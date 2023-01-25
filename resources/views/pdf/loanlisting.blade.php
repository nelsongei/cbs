<html><head>
    <title>Loan Listing Report</title>
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

    </style>
</head><body style="font-size:11px">
<?php
function asMoney($value)
{
    return number_format($value, 2);
}
?>
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
                <strong><h3>LOAN LISTING REPORT {{$period}}</h3></strong>
            </td>
        </tr>
        <tr>
            <hr>
        </tr>
    </table>
</div>
<div class="footer" >
    <p class="page">Page <?php $PAGE_NUM ?></p>
</div>
<div class="content">
    <table class="table table-bordered" border="1" cellspacing="0" cellpadding="5" style="width:100%">
        <tr>
            <td style="border-bottom:1px solid black;"><strong>Member #</strong></td>
            <td style="border-bottom:1px solid black;"><strong>Member Name</strong></td>
            <td style="border-bottom:1px solid black;"><strong>Loan Product</strong></td>
            <td style="border-bottom:1px solid black;"><strong>Loan Number</strong></td>
            <td style="border-bottom:1px solid black;"><strong>Loan Amount</strong></td>
            <td style="border-bottom:1px solid black;"><strong>Loan Balance</strong></td>
        </tr>
        <?php $loan_amount_total = 0; $loan_balance_total = 0; ?>
        @foreach($loans as $loan)
            @if(App\Models\LoanTransaction::getLoanBalance($loan) > 5)
                <?php 
                    $loanBalance = App\Models\LoanTransaction::getLoanBalanceAt($loan, $to);
                ?>
                <tr>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->member->membership_no}}</td>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->member->name}}</td>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->loanproduct->name}}</td>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{$loan->account_number}}</td>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney(App\Models\LoanApplication::getActualAmount($loan))}}</td>
                    <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">{{asMoney($loanBalance)}}</td>
                    <?php
                    $loan_amount_total += App\Model\LoanApplication::getLoanAmount($loan);
                    $loan_balance_total += $loanBalance;
                    ?>
                </tr>
            @endif
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="border-bottom:0.1px double black; border-right:0.1px solid black;">
                <strong>TOTAL: {{ asMoney($loan_amount_total) }}</strong>
            </td>
            <td style="border-bottom:0.1px double black; border-right:0.1px solid black;">
                <strong>TOTAL: {{ asMoney($loan_balance_total) }}</strong>
            </td>
        </tr>
    </table>
</div>
</body></html>
