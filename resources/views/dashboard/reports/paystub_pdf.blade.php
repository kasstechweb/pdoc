<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        body{font-family: 'Helvetica', 'Arial', sans-serif; padding-bottom: 5%}
        .p-5{padding: 5%;}
        .pt-1{padding-top: 1%;}
        .pb-1{padding-bottom: 1%;}
        .pb-2{padding-bottom: 2%;}
        .pt-2{padding-top: 2%;}
        .pr-2 {padding-right: 2%;}
        .pr-5 {padding-right: 5%;}
        .pr-5 {padding-right: 5%;}
        .pr-10 {padding-right: 10%;}
        .pr-15 {padding-right: 15%;}
        .pr-20 {padding-right: 20%;}
        .pl-1{padding-left: 1%;}
        .dashed-top-border {border-top: 2px dashed black;}
        .border-bottom-solid {border-bottom: 1px solid black;}
        .border-top-solid {border-top: 1px solid black;}
        .width-20 {width: 20%;}
        .width-25 {width: 25%;}
        .width-50 {width: 50%;}
        .float-left {float: left}
        .text-bold {font-weight: bold;}
        .text-10 {font-size: 10px;}
        .text-11 {font-size: 11px;}
        .text-12 {font-size: 12px;}
        .text-13 {font-size: 13px;}
        .text-15 {font-size: 15px;}
        .text-20 {font-size: 20px;}
        .text-right{text-align: right}
        .text-left{text-align: left}

        .display-flex {display: flex;}
        .d-block {display: inline-block;}
        table {
            border-collapse: collapse;
        }
    </style>

</head>
<body>
<p class="p-5 text-15"> <!-- CHANGE -->
    {{ $employer->name }} <br />
    {{ $employer->address }}
{{--    10534 82 AVE NW <br />--}}
{{--    EDMONTON, AB T6E2A4--}}
</p>
<p class="p-5 text-15"> <!-- CHANGE -->
    {{ $employee->name }}<br >
    {{ $employee->address }}
</p>

<div class="dashed-top-border pt-1" > <!-- CHANGE -->
    <div class="width-25 text-10 text-bold text-left d-block">Employee Paystub</div>
    <div class="width-25 text-10 text-bold text-left d-block">Cheque number:</div>
    <div class="width-25 text-10 text-bold text-left d-block">Pay Period: {{ $data['start_date'] }} - {{ $data['pay_date'] }}</div>
    <div class="width-25 text-10 text-right text-bold d-block">Cheque Date: {{ $data['pay_date'] }}</div>
</div>
<table style="width: 100%" class="pb-2">
    <thead>
    <tr class="text-10">
        <th class="width-50 text-left border-bottom-solid">Employee</th>
        <th class="text-left border-bottom-solid">Occupation</th>
    </tr>
    </thead>
    <tbody>
    <tr class="text-10">
        <td>{{ $employee->name }}, {{ $employee->address }}</td>
        <td></td>
    </tr>
    </tbody>
</table>
@php
$total_hourly = $paystub->hourly_qty * $paystub->hourly_rate;
$total_stat = $paystub->stat_qty * $paystub->stat_rate;
$total_overtime = $paystub->overtime_qty * $paystub->overtime_rate;

$total_income = $total_hourly + $total_stat + $total_overtime + $paystub->vac_pay;
$total_deductions = $paystub->cpp + $paystub->ei + $paystub->federal_tax;
@endphp
<table cellspacing="0" width="50%">
    <thead>
    <tr class="text-10">
        <th class="border-bottom-solid text-left">Earnings and Hours</th>
        <th class="border-bottom-solid text-left">Qty</th>
        <th class="border-bottom-solid text-left">Rate</th>
        <th class="border-bottom-solid text-left">Current</th>
        <th class="border-bottom-solid text-left">YTD Amount</th>
    </tr>
    </thead>
    <tbody>
        <tr class="text-10">
            <td class="text-left">hourly</td>
            <td class="text-left">{{ convertTime($paystub->hourly_qty) }}</td>
            <td class="text-left">{{ number_format($paystub->hourly_rate, 2) }}</td>
            <td class="text-left">{{ number_format(round($total_hourly, 2), 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">STAT PAY</td>
            <td class="text-left">{{ convertTime(number_format($paystub->stat_qty, 2)) }}</td>
            <td class="text-left">{{ number_format($paystub->stat_rate, 2) }}</td>
            <td class="text-left">{{ number_format(round($total_stat, 2), 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">VacPay-Paid Out</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">{{ number_format($paystub->vac_pay, 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">Overtime</td>
            <td class="text-left">{{ convertTime(number_format($paystub->overtime_qty, 2)) }}</td>
            <td class="text-left">{{ number_format($paystub->overtime_rate, 2) }}</td>
            <td class="text-left">{{ number_format(round($total_overtime, 2), 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td></td> <!-- TOTAL Calculations -->
            <td class="text-left border-top-solid">
                {{ convertTime(number_format($paystub->hourly_qty + $paystub->stat_qty + $paystub->overtime_qty, 2)) }}
            </td>
            <td class="text-left border-top-solid"></td>
            <td class="text-left border-top-solid">
                {{number_format(round( $total_income , 2), 2) }}
            </td>
            <td class="text-left border-top-solid">TBD</td>
        </tr>
        <tr><td style="height: 20px" colspan="5"></td></tr>
    </tbody>
    <thead>
        <tr class="text-10">
            <th colspan="3" class="border-bottom-solid text-left">Withholdings</th>
            <th class="border-bottom-solid text-left">Current</th>
            <th class="border-bottom-solid text-left">YTD Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-10">
            <td class="text-left">CPP - Employee</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">- {{ number_format($paystub->cpp, 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">EI - Employee</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">- {{ number_format($paystub->ei, 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">Federal Income Tax</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">- {{ number_format($paystub->federal_tax, 2) }}</td>
            <td class="text-left">TBD</td>
        </tr>
        <tr class="text-10"> <!-- TOTAL -->
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left border-top-solid">- {{ number_format(round($total_deductions, 2), 2) }}</td>
            <td class="text-left border-top-solid">TBD</td>
        </tr>
        <tr><td style="height: 20px" colspan="5"></td></tr>
        <tr class="text-10">
            <td class="text-left text-bold">Net Pay</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left text-bold">{{ number_format( round( $total_income - $total_deductions , 2) , 2) }}</td>
            <td class="text-left text-bold">TBD</td>
        </tr>
    </tbody>

</table>
<footer>
    <p class="p-5 text-10" style="position: absolute;bottom: 1%">
        {{ $employer->name }}, {{ $employer->address }}
    </p>
</footer>
</body>
</html>

<?php
function convertTime($dec){
    // start by converting to seconds
    $seconds = ($dec * 3600);
    // we're given hours, so let's get those the easy way
    $hours = floor($dec);
    // since we've "calculated" hours, let's remove them from the seconds variable
    $seconds -= $hours * 3600;
    // calculate minutes left
    $minutes = floor($seconds / 60);
    // remove those from seconds as well
    $seconds -= $minutes * 60;
    // return the time formatted HH:MM:SS
    //return lz($hours).":".lz($minutes).":".lz($seconds);
    return lz($hours).":".lz($minutes);
}

// lz = leading zero
function lz($num){return (strlen($num) < 2) ? "0{$num}" : $num;}
?>
