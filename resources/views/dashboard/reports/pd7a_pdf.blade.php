<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        body{font-family: 'Helvetica', 'Arial', sans-serif; padding-bottom: 5%}
        .p-2{padding: 2%;}
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
        .pl-2{padding-left: 2%;}
        .pl-3{padding-left: 3%;}
        .dashed-top-border {border-top: 2px dashed black;}
        .border-bottom-solid {border-bottom: 1px solid black;}
        .border-top-solid {border-top: 1px solid black;}
        .width-20 {width: 20%;}
        .width-25 {width: 25%;}
        .width-50 {width: 50%;}
        .width-75 {width: 75%;}
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
        .text-center {text-align: center}

        .display-flex {display: flex;}
        .d-block {display: inline-block;}
        .m-0 {margin: 0}
        table {
            border-collapse: collapse;
        }
    </style>

</head>
<body>
{{--<div class="p-2 text-center">--}}
{{--    <div class="width-25 text-10 text-bold text-left d-block">5:20 PM</div>--}}
{{--    <div class="width-50 text-bold text-left d-block">Escapes Adventures Edmonton Inc.</div>--}}
{{--</div>--}}
<div class="pt-2 pr-2 pl-2 text-center">
    <p class="width-20 text-10 text-bold text-left d-block m-0">5:20 PM</p>
    <p class="width-75 text-bold d-block m-0">Escapes Adventures Edmonton Inc.</p>
</div>
<div class="pr-2 pl-2 text-center" style="border-bottom: 2px solid black">
    <p class="width-20 text-10 text-bold text-left d-block m-0">2018-12-12</p>
    <p class="width-75 text-bold d-block m-0">PD7A Summary</p>
    <p class="width-20 text-10 text-bold text-left d-block m-0"></p>
    <p class="width-75 text-13 text-bold d-block m-0">{{ $total['month_word'] }} {{ $total['year'] }}</p>
</div>
<hr class="m-0">
<br>
<table style="width: 100%" class="pb-2">

    <tbody>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-left"></td>
        <td class="text-center">{{ $total['month_small'] }} {{ $total['year'] - 2000 }}</td>
        <td class="text-center"> </td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pr-2">Gross payroll for period</td>
        <td class="text-left border-top-solid">{{ number_format( round($total['income'], 2) ,2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pr-2">No. of employees paid in period</td>
        <td class="text-left">{{ $total['employees'] }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr><td style="height: 20px" colspan="5"></td></tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">Tax deductions</td>
        <td class="text-left">{{ number_format( round($total['ftax'], 2) ,2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr><td style="height: 20px" colspan="5"></td></tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">CPP - Employee</td>
        <td class="text-left">{{ number_format( round($total['employee_cpp'], 2) ,2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">CPP - Company</td>
        <td class="text-left border-bottom-solid">{{ number_format( round($total['employer_cpp'], 2) ,2)  }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">Total CPP contributions</td>
        <td class="text-left">{{ number_format( round($total['total_cpp'], 2) ,2)  }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr><td style="height: 20px" colspan="5"></td></tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">EI - Employee</td>
        <td class="text-left">{{ number_format( round($total['employee_ei'], 2) ,2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">EI - Company</td>
        <td class="text-left border-bottom-solid">{{ number_format( round($total['employer_ei'], 2) ,2) }} </td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pl-2 pr-2">Total EI premiums</td>
        <td class="text-left">{{ number_format( round($total['total_ei'], 2), 2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr><td style="height: 20px" colspan="5"></td></tr>
    <tr class="text-13">
        <td class="text-left"></td>
        <td class="text-right pr-2">Total Remittance for period</td>
        <td class="text-left border-top-solid">{{ number_format( round($total['total_deductions'], 2), 2) }}</td>
        <td class="text-left"></td>
        <td class="text-left"></td>
    </tr>
    <tr><td style="height: 20px" colspan="5"></td></tr>
    </tbody>

</table>
</body>
</html>
