<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loans</title>
    <style>
        @page {
            margin: 90px 30px 70px 30px;
        }

        .header {
            position: fixed;
            left: 0px;
            top: -90px;
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
            margin-top: 27px;
        }
    </style>
</head>
<body style="font-size:13px">
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
                        {{ strtoupper($organization->name) }}<br>
                    </strong>
                    {{ $organization->phone }} |
                    {{ $organization->email }} |
                    {{ $organization->website }}<br>
                    {{ $organization->address }}
                </td>
                <td>
                    <strong>
                        <h3>{{ $loanProduct->name }} REPORT {{ $period }}</h3>
                    </strong>
                </td>
            </tr>
            <tr>
                <hr>
            </tr>
        </table>
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
            <?php $totalDisbursed = 0;
            $totalBalance = 0; ?>
            @foreach ($loans as $loan)
                @if (App\Models\LoanTransaction::getLoanBalance($loan) > 5)
                    <?php
                    $loanBalance = App\Models\LoanTransaction::getLoanBalanceAt($loan, $to);
                    ?>
                    <tr>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ $loan->member->membership_no }}</td>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ $loan->member->name }}</td>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ $loan->loanproduct->name }}</td>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ $loan->account_number }}</td>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ asMoney($loan->amount_disbursed) }}</td>
                        <td style="border-bottom:0.1px solid black; border-right:0.1px solid black;">
                            {{ asMoney($loanBalance) }}</td>
                        <?php $totalDisbursed += $loan->amount_disbursed;
                        $totalBalance += $loanBalance; ?>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"> <strong>Total</strong> </td>
                <td>{{ asMoney($totalDisbursed) }}</td>
                <td>{{ asMoney($totalBalance) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>