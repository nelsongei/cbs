<html><head>
    <style>
        @page {
            margin: 170px 30px;
        }

        .header {
            position: fixed;
            left: 0px;
            top: -150px;
            right: 0px;
            height: 150px;
            text-align: center;
        }

        .footer {
            position: fixed;
            left: 0px;
            bottom: -180px;
            right: 0px;
            height: 50px;
        }

        .footer .page:after {
            content: counter(page, upper-roman);
        }

        .content {
            margin-top: -70px;
        }

    </style><body style="font-size:10px">
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
                <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="{{ $organization->logo }}"
                     style="height: 50px;"/>

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
                <strong><h3>LOAN STATEMENT </h3></strong>
            </td>
        </tr>
        <tr>
            <hr>
        </tr>
    </table>
</div>
<div class="footer">
    <p class="page">Page <?php $PAGE_NUM ?></p>
</div>


<div class="content">


    <table class="table table-bordered" style="width:60%">


        <tr>
            <td style="width:17%">Member</td>
            <td>{{ucwords($account->member->name)}}</td>

        </tr>

        <tr>
            <td>Member #</td>
            <td>{{ucwords($account->member->membership_no)}}</td>

        </tr>
        <tr>
            <td>Loan #</td>
            <td>{{$account->account_number}}</td>
        </tr>
        <tr>
            <td>Loan Amount</td>
            <!-- TODO: Work on loan amount -->
            <td>{{asMoney(\App\Models\LoanApplication::getPrincipalBal($account) + \App\Models\LoanRepayment::getPrincipalPaid($account))}}</td>
        </tr>
        <!--
          <tr>
            <td>Interest Amount</td><td>{{asMoney(\App\Models\LoanApplication::getInterestAmount($account))}}</td>

          </tr>
        -->
    </table>
    <br><br>
    <table class="table table-bordered" style="width:100%">
        <tr style="font-weight:bold">
            <td></td>

            <td>Date</td>
            <td>Description</td>
            <td>Principal</td>
            <td>Interest</td>
            <td>Principal Balance</td>

        </tr>

        <tbody>


        <tr>
            <td>
                <?php

                $date = date("d-M-Y", strtotime($account->date_disbursed));
                ?>

                {{$date}}</td>
            <td>Loan disbursed</td>
            <td>{{asMoney($account->amount_disbursed)}}</td>
            <td>{{asMoney(0)}}</td>
            <td>{{asMoney($account->amount_disbursed)}}</td>

        </tr>


        <?php

        $principal_balance = $account->amount_disbursed+$account->top_up_amount;
        $interest_balance = \App\Models\LoanApplication::getInterestAmount($account);

        $prinpaid = 0;
        $intpaid = 0;
        ?>

        @foreach($transactions as $transaction)

            @if($transaction->hasRepayment)
                @foreach($transaction->repayments as $repayment)
                    @if($account->date_disbursed < $repayment->date)
                        <tr>

                            <td>

                                    <?php

                                    $date = date("d-M-Y", strtotime($repayment->date));
                                    ?>

                                {{$date}}</td>
                            <td>

                                @if($repayment->principal_paid > 0) Principal repayment @endif
                                @if($repayment->interest_paid > 0) Interest repayment @endif

                            </td>
                            <td>

                                    <?php $prinpaid = $prinpaid + $repayment->principal_paid; ?>
                                {{asMoney($repayment->principal_paid)}}</td>
                            <td>

                                    <?php $intpaid = $intpaid + $repayment->interest_paid; ?>
                                {{asMoney($repayment->interest_paid)}}</td>
                            <td>{{asMoney($principal_balance = $principal_balance- $repayment->principal_paid)}}</td>


                        </tr>
                    @endif
                @endforeach
            @else
                @if(!($transaction->description)=='loan disbursement')
                    <tr>

                        <td>

                                <?php

                                $date = date("d-M-Y", strtotime($transaction->date));
                                ?>

                            {{$date}}</td>
                        <td>

                            {{ $transaction->description }}

                        </td>
                        <td>

                            {{asMoney($transaction->amount)}}</td>
                        <td>
                            0.00
                        </td>
                        <td>{{asMoney($principal_balance = $principal_balance + $transaction->amount)}}</td>


                    </tr>
                @endif
            @endif

        @endforeach
        <tr>
            <td></td>
            <td style=" font-weight:bold">Total Repayments</td>
            <td style="border-top:2px solid black; font-weight:bold">{{ asMoney($prinpaid)}}</td>
            <td style="border-top:2px solid black;font-weight:bold">{{ asMoney($intpaid)}}</td>
            <td></td>


        </tr>


        </tbody></table>


</div>
</body></html>
