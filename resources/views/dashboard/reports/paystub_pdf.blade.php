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
    Escapes Adventures Edmonton Inc. <br />
    10534 82 AVE NW <br />
    EDMONTON, AB T6E2A4
</p>
<p class="p-5 text-15"> <!-- CHANGE -->
    ANGELINE MANABAT<br >
    13014-102 STREET NW<br >
    EDMONTON, AB T5E 4J5
</p>

<div class="dashed-top-border pt-1" > <!-- CHANGE -->
    <div class="width-25 text-10 text-bold text-left d-block">Employee Paystub</div>
    <div class="width-25 text-10 text-bold text-left d-block">Cheque number:</div>
    <div class="width-25 text-10 text-bold text-left d-block">Pay Period: 2018-11-01 - 2018-11-15</div>
    <div class="width-25 text-10 text-right text-bold d-block">Cheque Date: 2018-11-15</div>
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
        <td>ANGELINE MANABAT, 13014-102 STREET NW, EDMONTON, AB T5E 4J5</td>
        <td></td>
    </tr>
    </tbody>
</table>
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
            <td class="text-left">61:53</td>
            <td class="text-left">16.00</td>
            <td class="text-left">990.13</td>
            <td class="text-left">17,827.72</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">STAT PAY</td>
            <td class="text-left">6:27</td>
            <td class="text-left">24.00</td>
            <td class="text-left">154.80</td>
            <td class="text-left">407.20</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">VacPay-Paid Out</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">39.61</td>
            <td class="text-left">717.32</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">Overtime</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">105.00</td>
        </tr>
        <tr class="text-10">
            <td></td>
            <td class="text-left border-top-solid">69:20</td>
            <td class="text-left border-top-solid"></td>
            <td class="text-left border-top-solid">1,287.29</td>
            <td class="text-left border-top-solid">19,726.61</td>
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
            <td class="text-left">-56.50</td>
            <td class="text-left">-839.32</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">EI - Employee</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">-21.37</td>
            <td class="text-left">-327.45</td>
        </tr>
        <tr class="text-10">
            <td class="text-left">Federal Income Tax</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left">-142.27</td>
            <td class="text-left">-1,684.77</td>
        </tr>
        <tr class="text-10">
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left border-top-solid">-220.14</td>
            <td class="text-left border-top-solid">-2,851.54</td>
        </tr>
        <tr><td style="height: 20px" colspan="5"></td></tr>
        <tr class="text-10">
            <td class="text-left text-bold">Net Pay</td>
            <td class="text-left"></td>
            <td class="text-left"></td>
            <td class="text-left text-bold">958.23</td>
            <td class="text-left text-bold">17,833.30</td>
        </tr>
    </tbody>

</table>
<!--
<div class="pt-1 pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="solid-bottom-border width-50 text-bold">Withholdings</div>
        <div class="solid-bottom-border width-50 text-bold display-flex pb-1 pl-1">
            <div class="width-25">Qty</div>
            <div class="width-25">Rate</div>
            <div class="width-25">Current</div>
            <div class="width-25">YTD Amount</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
<div class="pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="width-50">hourly</div>
        <div class="width-50 text-bold display-flex pb-1 pl-1">
            <div class="width-25">61:53</div>
            <div class="width-25">16.00 </div>
            <div class="width-25">990.13 </div>
            <div class="width-25">17,827.72</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
<div class="pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="width-50">STAT PAY</div>
        <div class="width-50 text-bold display-flex pb-1 pl-1">
            <div class="width-25">6:27</div>
            <div class="width-25">24.00</div>
            <div class="width-25">154.80</div>
            <div class="width-25"> 407.20</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
<div class="pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="width-50">VacPay-Paid Out</div>
        <div class="width-50 text-bold display-flex pb-1 pl-1">
            <div class="width-25"></div>
            <div class="width-25"></div>
            <div class="width-25">39.61</div>
            <div class="width-25">717.32</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
<div class="pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="width-50">Overtime</div>
        <div class="width-50 text-bold display-flex pb-1 pl-1">
            <div class="width-25"></div>
            <div class="width-25"></div>
            <div class="width-25"></div>
            <div class="width-25">105.00</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
<div class="pb-1 display-flex">
    <div class="width-50 text-10 display-flex">
        <div class="width-50"></div>
        <div class="width-50 text-bold display-flex pb-1 border-top-solid pl-1">
            <div class="width-25">69:20</div>
            <div class="width-25"> </div>
            <div class="width-25">1,287.29 </div>
            <div class="width-25">19,726.61</div>
        </div>
    </div>
    <div class="width-50 text-10"></div>
</div>
-->
</body>
</html>

{{--<?php--}}
{{--//    foreach ($employees as $employee){--}}
{{--//        echo $employee->id;--}}
{{--//        echo $employee->name;--}}
{{--//    }--}}
{{--  echo '<br />'. $data['pay_date'] .'<br />';--}}
{{--//echo $pay_date;--}}
{{--?>--}}
{{--test2--}}
