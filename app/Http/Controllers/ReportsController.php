<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paystubsForm(Request $request){
        $frequencies = DB::table('frequency')->get();
        if ($request->method() == 'POST') {
            $employees = Employee::all();
            return view('dashboard.reports.paystubs_form')
                ->with('frequencies', $frequencies)
                ->with('payment_date', $request->input('payment_date'))
                ->with('employees', $employees)
                ->with('freq', $request->input('frequency'));
        }else {
            return view('dashboard.reports.paystubs_form')
                ->with('frequencies', $frequencies)
                ->with('payment_date', null)
                ->with('employees', null)
                ->with('freq', null);
        }
    }
//    public function payStubsView(){
//        $employees = Employee::all();
//        return view('dashboard.reports.paystubs')
//            ->with('employees', $employees);
//    }
//
//    public function payStubsShowEmployees() {
//
//    }

    public function pdocAjax(Request $request){
        $employer_name = Auth::user()->name;
        $province_id = Auth::user()->province_id;
        $provinces = DB::table('provinces')->where('id', '=', $province_id)->first();
        $employer_province = $provinces->name;
        $employer_province = strtoupper($employer_province);
        $employer_province = str_replace(' ', '_', $employer_province);

        $employee_id = $request->employee_id;
        $frequency = $request->frequency;
        $start_date = $request->start_date;
        $pay_date = $request->pay_date;

        // getting employee details
        $employee = Employee::find($employee_id);
        $employee_rate = $employee->pay_rate;
        $employee_name = $employee->name;

        //  getting employee work hours
        $hours = Hour::where('employee_id', $employee_id)->whereBetween('work_date', [$start_date, $pay_date])->get();
        $total_hours = 0;$total_stat_hours = 0;$total_overtime_hours = 0;

        foreach ($hours as $hour){
            if ($hour->is_state_holiday == 1){
                $total_stat_hours += $hour->work_hours;
            }elseif ($hour->is_over_time == 1){
                $total_overtime_hours += $hour->work_hours;
            }else {
                $total_hours += $hour->work_hours;
            }
        }

        // do calculations
        $hourly = $total_hours * $employee_rate;
        $vac_pay = $hourly * 0.04;

        // split pay date
        $payment_date = explode('-', $pay_date, 3);
        $year = $payment_date[0];
        $month = $payment_date[1];
        $day = $payment_date[2];

        $pdoc_result = $this->pdoc($hourly, $vac_pay, $year, $month, $day, $employee_name, $employer_name, $employer_province, $frequency);
//        dd($total_hourly);
        //        $hourly = hours
        return response()->json(array(
            'total hours'=> $total_hours,
            'total stat' => $total_stat_hours,
            'total overtime' => $total_overtime_hours,
            'freq' => $frequency,
            'employee name' => $employee_name,
            'prov id' => $employer_province,
            'hourly' => $hourly,
            'pdoc_result' => $pdoc_result
        ), 200);
    }
//
    public function pdoc($hourly, $vac_pay, $year, $month, $day, $employee_name, $employer_name, $province, $frequency){
//        $hourly = '1088.27';
//        $vac_pay = '43.53';
//        $year = '2018';
//        $month = '11';
//        $day = '30';
//        $employee_name = 'full name test';
//        $employer_name = 'employer name';
//        $province = 'ALBERTA';
//        $frequency = 'SEMI_MONTHLY';
        include(app_path() . '\pdoc\simple_html_dom.php');
        touch('cra-cookies.txt');

        $retval = array();
        $retval['status'] = 'success';
        $retval2 = array();
        $retval2['status'] = 'success';

        if ($retval['status'] != 'error') {

            $param = array();

            // $param['income'] = ($_GET['hourly'] * $_GET['hours']);
            $param['income'] = $hourly; //'1,088.27'
            // $param['vacationPay'] = round($param['income'] * 0.04, 2);
            $param['vacationPay'] = $vac_pay; //'43.53'
            $param['year'] = $year; //'2018'
            $param['month'] = $month; //'11'
            $param['day'] = $day; //'30'

            $param['month'] = str_pad($param['month'], 2, '0', STR_PAD_LEFT);
            $param['day'] = str_pad($param['day'], 2, '0', STR_PAD_LEFT);

            $data = array(
                "step0" => array(
                    "calculationType" => "SALARY",        // Salary
                    "action:welcome_NextButton" => "Next",
                ),
                "step1" => array(
                    "employeeName" => $employee_name, //"ANGELINE"
                    "employerName" => $employer_name, //"EXIT"
                    // "jurisdiction" => "PRINCE_EDWARD_ISLAND",                    // Prince Edward Island
                    "jurisdiction" => $province, //"ALBERTA"
                    "payPeriodFrequency" => $frequency,   //"SEMI_MONTHLY"                    // Weekly
                    "datePaidYear" => $param['year'],
                    "datePaidMonth" => $param['month'],
                    "datePaidDay" => $param['day'],
                    "action:payrollDeductionsStep1_NextButton" => "Next"
                ),
                "step2" => array(
                    "incomeAmount" => $param['income'],
                    "vacationPay" => $param['vacationPay'],
                    "salaryType" => "NO_BONUS_PAY_NO_RETROACTIVE_PAY",
                    "clergyType" => "NOT_APPLICABLE",
                    "action:payrollDeductionsStep2a_NextButton" => "Next"
                ),
                "step3" => array(
                    "federalClaimCode" => "CLAIM_CODE_1",
                    "provinceTerritoryClaimCode" => "CLAIM_CODE_1",
                    "requestedAdditionalTaxDeductions" => "0.00",
                    "pensionableEarningsYearToDate" => "0",
                    "cppOrQppContributionsDeductedYearToDate" => "0",
                    "cppQppType" => "CPP_QPP_YEAR_TO_DATE",
                    "insurableEarningsYearToDate" => "0",
                    "employmentInsuranceType" => "EI_YEAR_TO_DATE",
                    "employmentInsuranceDeductedYearToDate" => "0",
                    "reducedEIRate" => "0",
                    "employerEmploymentInsurancePremiumRate" => 1.4,
                    "action:payrollDeductionsStep3_CalculateButton" => "Calculate"
                ),
                "step4" => array(
                    "action:payrollDeductionsResults_RemittanceSummaryButton" => "Employer Remittance Summary"
                ),
            );

            $triggers = array(
                "federalTax" => array("Federal tax deduction", 3),
                "provincialTax" => array("Provincial tax deduction", 4),
                "CPP" => array("CPP deductions", 4),
                "EI" => array("EI deductions", 4),
            );
            $triggers2 = array(
                "employerCPP" => array("Employer CPP contributions", 4),
                "employerEI" => array("Employer EI contributions", 4),
            );
// to get token
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action',
                    'post'  => false)
            );
            $hidden = $this->getHiddenFormValueFromHTML($result);
            $data['step0'] = array_merge($data['step0'], $hidden);

// doing step 0 -> choose salary
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action?request_locale=en_CA',
                    'post'  => http_build_query($data['step0'], '', '&'))
            );

            $hidden = $this->getHiddenFormValueFromHTML($result);
            $data['step1'] = array_merge($data['step1'], $hidden);

            // doing step 1 name, province, date
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep1_fromWelcome.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep1_fromWelcome.action',
                    'post' => http_build_query($data['step1'], '', '&'))
            );
            $hidden = $this->getHiddenFormValueFromHTML($result);
            $data['step2'] = array_merge($data['step2'], $hidden);

            // doing step 2 income, vacation
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep2a_fromPayrollDeductionsStep1.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep2a_fromPayrollDeductionsStep1.action',
                    'post' => http_build_query($data['step2'], '', '&'))
            );
            $hidden = $this->getHiddenFormValueFromHTML($result);
            $data['step3'] = array_merge($data['step3'], $hidden);

            // doing step 3
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep3_fromPayrollDeductionsStep2b.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep3_fromPayrollDeductionsStep2b.action',
                    'post' => http_build_query($data['step3'], '', '&'))
            );
            $hidden = $this->getHiddenFormValueFromHTML($result);
            // step 4
            $result2 = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsRemittanceSummary_fromPayrollDeductionsResults.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsRemittanceSummary_fromPayrollDeductionsResults.action',
                    'post' => http_build_query($data['step4'], '', '&'))
            );
//            echo "<br> result: ------------------------------------------------------------";
//            print_r($result);
//            echo "<br>";
//            echo "<br> result2: ------------------------------------------------------------";
//            print_r($result2);
//            echo "<br>";

            $lines = explode("\n", $result);
//
            foreach ($lines as $linenumber => $line) {
                foreach ($triggers as $key => $trigger) {
                    if (strpos($line, $trigger[0]) !== FALSE) {
                        $values[$key] = trim($lines[$linenumber + $trigger[1]]);
                    }
                }
            }
            $retval['values'] = $values;

            $lines2 = explode("\n", $result2);
//
            foreach ($lines2 as $linenumber => $line) {
                foreach ($triggers2 as $key => $trigger) {
                    if (strpos($line, $trigger[0]) !== FALSE) {
                        $values2[$key] = trim($lines2[$linenumber + $trigger[1]]);
                    }
                }
            }
            $retval2['values'] = $values2;
        }

        $retval['values2'] = $retval2;
//        print json_encode($retval);
//        print json_encode($retval2);
        return $retval;
    }

    function fetch($url, $z=null) {
        $ch =  curl_init();

        $useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2';

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_POST, isset($z['post']) );

        if( isset($z['post']) )         curl_setopt( $ch, CURLOPT_POSTFIELDS, $z['post'] );
        if( isset($z['refer']) )        curl_setopt( $ch, CURLOPT_REFERER, $z['refer'] );

        curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cra-cookies.txt' );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cra-cookies.txt' );

        $result = curl_exec( $ch );
        curl_close( $ch );

        return $result;
    }

    function getHiddenFormValueFromHTML($html) {
        $html = str_get_html($html);
        $nodes = $html->find("input[type=hidden]");
        $hidden = array();
        foreach ($nodes as $node) {
            $hidden[$node->attr['name']] = $node->attr['value'];
        }
        return $hidden;
    }
}
