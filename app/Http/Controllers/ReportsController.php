<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use App\Models\Paystub;
use App\Models\Setting;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Validator;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function settings(Request $request) {
        if ($request->method() == 'POST') {
            $messages = [
                'stat.required' => 'The stat holiday Number is required.',
            ];

            $validator = Validator::make($request->all(), [
                'stat' => 'required|numeric|between:0,99.99',
                'overtime' => 'required|numeric|between:0,99.99',
                'max_cpp' => 'required|numeric|between:0,999.99',
                'max_ei' => 'required|numeric|between:0,999.99',
            ], $messages);

            if ($validator->fails()) {
                return redirect(route('settings'))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $setting = Setting::find(1);
                $setting->stat_amount = $request->input('stat');
                $setting->overtime_amount = $request->input('overtime');
                $setting->max_cpp = $request->input('max_cpp');
                $setting->max_ei = $request->input('max_ei');
                $setting->save();

                $settings = Setting::where('id', 1)->first();
                return redirect(route('settings'))
                    ->with('msg', 'settings update Success!')
                    ->with('settings', $settings);
            }
        }else {
            $settings = Setting::where('id', 1)->first();
            return view('dashboard.reports.settings')
                ->with('settings', $settings);
        }
    }

    public function paystubsForm(Request $request){
        $frequencies = DB::table('frequency')->get();
        if ($request->method() == 'POST') {
            $employees = Employee::whereDate('termination_date', '>=', $request->input('payment_date'))->get();
//            dd($employees);
            // get previous pay stubs same date and frequency using pay date and frequency
            $paystubs = Paystub::where([
                ['paid_date', '=',$request->input('payment_date')],
                ['pay_frequency', '=', $request->input('frequency')]
                ])->get();

            return view('dashboard.reports.paystubs_form')
                ->with('frequencies', $frequencies)
                ->with('payment_date', $request->input('payment_date'))
                ->with('employees', $employees)
                ->with('freq', $request->input('frequency'))
                ->with('paystubs', $paystubs);
        }else {
            return view('dashboard.reports.paystubs_form')
                ->with('frequencies', $frequencies)
                ->with('payment_date', null)
                ->with('employees', null)
                ->with('freq', null);
        }
    }

    public function pdocAjax(Request $request){
        $employer_name = Auth::user()->name;
        $employer_id = Auth::id();
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
        $employee_cpp_exempt = $employee->cpp_exempt;
        $employee_ei_exempt = $employee->ei_exempt;

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

        // get from settings
        $settings = Setting::where('id', 1)->first();
//        dd($settings->stat_amount);
        // do calculations
        $hourly = round($total_hours * $employee_rate, 2);
        $vac_pay = round($hourly * 0.04, 2);
        $stat_pay = round($total_stat_hours * ($employee_rate * $settings->stat_amount), 2); //TODO::::: get it from settings
        $overtime_pay = round($total_overtime_hours * ($employee_rate * $settings->overtime_amount), 2); // TODO::::::: get from settings

        // split pay date
        $payment_date = explode('-', $pay_date, 3);
        $year = $payment_date[0];
        $month = $payment_date[1];
        $day = $payment_date[2];

//            dd($hourly. ' '. $vac_pay. ' '. $year. ' '. $month. ' '. $day. ' '. ''. ' '. ''. ' '. $employer_province. ' '. $frequency);
//
        $pdoc_result = $this->pdoc($hourly, $vac_pay, $year, $month, $day, $employee_name, $employer_name, $employer_province, $frequency);

        $employee_cpp = $pdoc_result['values']['CPP'];
        $employee_ei = $pdoc_result['values']['EI'];
        $federal_tax = $pdoc_result['values']['federalTax'];
        $employer_cpp = $pdoc_result['values2']['values']['employerCPP'];
        $employer_ei = $pdoc_result['values2']['values']['employerEI'];
//
        // get year to date data
        $date = DateTime::createFromFormat("Y-m-d", $pay_date);
        $year = $date->format('Y');
        $new_date = $year . '-01-01';
        $ytds = Paystub::where([
            ['employee_id', '=', $employee_id],
            ['employer_id', '=', Auth::id()]
        ])->whereBetween('paid_date', [$new_date, $pay_date])->get();

        // do the calculations
        $ytd['hourly'] = 0; $ytd['stat'] = 0; $ytd['vac'] = 0; $ytd['overtime'] = 0;
        $ytd['cpp'] = 0; $ytd['ei'] = 0; $ytd['ftax'] = 0;
        foreach ($ytds as $stub){
            $ytd['hourly']      += $stub->hourly_qty * $stub->hourly_rate;
            $ytd['stat']        += $stub->stat_qty * $stub->stat_rate;
            $ytd['vac']         += $stub->vac_pay ;
            $ytd['overtime']    += $stub->overtime_qty * $stub->overtime_rate;
            $ytd['cpp']         += $stub->cpp;
            $ytd['ei']          += $stub->ei;
            $ytd['ftax']        += $stub->federal_tax;
        }

        $total_income = $hourly + $vac_pay + $stat_pay + $overtime_pay;
        $net_pay = $total_income;
        if ($settings->max_cpp >= ($ytd['cpp']+ $employee_cpp)) {
            $net_pay -= $employee_cpp;
        }else if ($settings->max_ei >= ($ytd['ei'] + $employee_ei)) {
            $net_pay -= $employee_ei;
        }
        $net_pay -= $federal_tax;
        //        dd($total_hourly);
        //        $hourly = hours

        // save in db pay stubs
        $paystub = new Paystub();
        $paystub->employee_id = $employee_id;
        $paystub->employer_id = $employer_id;
        $paystub->paid_date = $pay_date;
        $paystub->hourly_qty = $total_hours;
        $paystub->hourly_rate = $employee_rate;
        $paystub->stat_qty = $total_stat_hours;
        $paystub->stat_rate = $employee_rate * $settings->stat_amount;
        $paystub->vac_pay = $vac_pay;
        $paystub->overtime_qty = $total_overtime_hours;
        $paystub->overtime_rate = $employee_rate * $settings->overtime_amount;
        if ($settings->max_cpp >= ($ytd['cpp'] + $employee_cpp) && !$employee_cpp_exempt) {
            $paystub->cpp = $employee_cpp;
        }elseif ($settings->max_cpp >= ($ytd['cpp']) && $ytd['cpp'] != $settings->max_cpp && !$employee_cpp_exempt){
            if (($ytd['cpp'] + $employee_cpp) > $settings->max_cpp) {
                $paystub->cpp = $settings->max_cpp - $ytd['cpp'];
            }else {
                $paystub->cpp = $employee_cpp;
            }
        }else {
            $paystub->cpp = 0;
        }
        if ($settings->max_ei >= ($ytd['ei'] + $employee_ei) && !$employee_ei_exempt) {
            $paystub->ei = $employee_ei;
        }elseif ($settings->max_ei >= ($ytd['ei']) && $ytd['ei'] != $settings->max_ei  && !$employee_ei_exempt){
            if (($ytd['ei'] + $employee_ei) > $settings->max_ei) {
                $paystub->ei = $settings->max_ei - $ytd['ei'];
            }else {
                $paystub->ei = $employee_ei;
            }
        }else {
            $paystub->ei = 0;
        }

        $paystub->federal_tax = $federal_tax;
        $paystub->net_pay = $net_pay;
        $paystub->pay_frequency = $frequency;
        $paystub->employer_cpp = $employer_cpp;
        $paystub->employer_ei = $employer_ei;
        $paystub->save();

        return response()->json(array(
            'status' => 'success',
            'total hours'=> $total_hours,
            'total stat' => $total_stat_hours,
            'total overtime' => $total_overtime_hours,
            'freq' => $frequency,
            'employee name' => $employee_name,
            'prov id' => $employer_province,
            'hourly' => $hourly,
            'vac pay' => $vac_pay,
            'pdoc_result' => $pdoc_result,
            'cpp' => $employee_cpp,
            'ei' => $employee_ei,
            'federal tax '=> $federal_tax,
            'emp cpp' => $employer_cpp,
            'emp ei' => $employer_ei
        ), 200);
    }

    public static function paystubPdf(Request $request){
//        dd($request->employee_id.$request->pay_date.$request->frequency);
//        return response()->json(array(
//            'status'=> 'success',
//        ), 200);
        $data['employee_id'] = $request->employee_id;
        $data['start_date'] = $request->first_date;
        $data['pay_date'] = $request->pay_date;
        $data['frequency'] = $request->frequency;
        // retrieve all records from db
        $employee = Employee::find($data['employee_id']);
        $employer = Auth::user();
        // get this paystub
        $paystub = Paystub::where([
            ['employee_id', '=', $data['employee_id']],
            ['paid_date', '=', $data['pay_date']],
            ['employer_id', '=', Auth::id()]
        ])->first();

        //get first day of this year
        $date = DateTime::createFromFormat("Y-m-d", $data['pay_date']);
        $year = $date->format('Y');
        $new_date = $year . '-01-01';

        // get year to date data
        $ytds = Paystub::where([
            ['employee_id', '=', $data['employee_id']],
            ['employer_id', '=', Auth::id()]
        ])->whereBetween('paid_date', [$new_date, $data['pay_date']])->get();

        // do the calculations
        $ytd['hourly'] = 0; $ytd['stat'] = 0; $ytd['vac'] = 0; $ytd['overtime'] = 0;
        $ytd['cpp'] = 0; $ytd['ei'] = 0; $ytd['ftax'] = 0;
        foreach ($ytds as $stub){
            $ytd['hourly']      += $stub->hourly_qty * $stub->hourly_rate;
            $ytd['stat']        += $stub->stat_qty * $stub->stat_rate;
            $ytd['vac']         += $stub->vac_pay ;
            $ytd['overtime']    += $stub->overtime_qty * $stub->overtime_rate;
            $ytd['cpp']         += $stub->cpp;
            $ytd['ei']          += $stub->ei;
            $ytd['ftax']        += $stub->federal_tax;
        }

//        dd($ytd);
        // share data to view
        view()->share('data',$data);
        view()->share('employee',$employee);
        view()->share('employer',$employer);
        view()->share('paystub',$paystub);
        view()->share('ytd',$ytd);
        $pdf = PDF::loadView('dashboard.reports.paystub_pdf', $data);

        // download PDF file with download method
        $file_name = $employee->name. '_'. $data['pay_date']. '.pdf';
        return $pdf->download($file_name);

    }

    public function deletePaystub($id){
        $paystub = Paystub::find($id);
        $paystub->delete();
        return redirect(route('paystubs_form'))
            ->with('msg', 'Paystub Delete Success!');
    }

    public function pd7a(Request $request) {

        if ($request->method() == 'POST') {
            $month = $request->input('month');
            $year = $request->input('year');
            $date_start = $year . '-'. $month . '-01';
            $date_end = $year . '-'. $month . '-31';
            // get year to date data
            $totals = Paystub::where('employer_id', '=', Auth::id())->whereBetween('paid_date', [$date_start, $date_end])->get();

            // do the calculations
            $employees_list = array();
            $total['hourly'] = 0; $total['stat'] = 0; $total['vac'] = 0; $total['overtime'] = 0;
            $total['employee_cpp'] = 0; $total['employee_ei'] = 0; $total['ftax'] = 0;
            $total['employees'] = 0;$total['employer_cpp'] = 0; $total['employer_ei'] = 0;
            foreach ($totals as $stub){
                if ( !in_array( $stub->employee_id, $employees_list)){
                    array_push($employees_list, $stub->employee_id);
                }
                $total['hourly']      += $stub->hourly_qty * $stub->hourly_rate;
                $total['stat']        += $stub->stat_qty * $stub->stat_rate;
                $total['vac']         += $stub->vac_pay ;
                $total['overtime']    += $stub->overtime_qty * $stub->overtime_rate;
                $total['employee_cpp']         += $stub->cpp;
                $total['employee_ei']          += $stub->ei;
                $total['employer_cpp']         += $stub->employer_cpp;
                $total['employer_ei']          += $stub->employer_ei;
                $total['ftax']        += $stub->federal_tax;
            }
            $total['income'] = $total['hourly'] + $total['stat'] + $total['vac'] + $total['overtime'];
            $total['total_cpp'] = $total['employee_cpp'] + $total['employer_cpp'] ;
            $total['total_ei'] = $total['employee_ei'] + $total['employer_ei'] ;
            $total['total_deductions'] = $total['ftax'] + $total['total_cpp'] + $total['total_ei'];
            $total['employees'] = count($employees_list);
//            dd($total);
            return redirect(route('pd7a'))
                ->withInput()
                ->with('total', $total);
//                ->with('settings', $settings);
        }else {
            return view('dashboard.reports.pd7a')
                ->with('total', null)
                ->with('month')
                ->with('year');
        }

    }

    public function pd7apdf(Request $request) {
        $month = $request->month;
        $year = $request->year;

        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $months_sm = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        for ($i=0; $i < count($months); $i++) {
            if (($i+1) == $month) {
               $total['month_word'] = $months[$i];
               $total['month_small'] = $months_sm[$i];
            }

        }

        $total['month'] = $month;
        $total['year'] = $year;

        $date_start = $year . '-'. $month . '-01';
        $date_end = $year . '-'. $month . '-31';
        // get year to date data
        $totals = Paystub::where('employer_id', '=', Auth::id())->whereBetween('paid_date', [$date_start, $date_end])->get();

        // do the calculations
        $employees_list = array();
        $total['hourly'] = 0; $total['stat'] = 0; $total['vac'] = 0; $total['overtime'] = 0;
        $total['employee_cpp'] = 0; $total['employee_ei'] = 0; $total['ftax'] = 0;
        $total['employees'] = 0;$total['employer_cpp'] = 0; $total['employer_ei'] = 0;
        foreach ($totals as $stub){
            if ( !in_array( $stub->employee_id, $employees_list)){
                array_push($employees_list, $stub->employee_id);
            }
            $total['hourly']      += $stub->hourly_qty * $stub->hourly_rate;
            $total['stat']        += $stub->stat_qty * $stub->stat_rate;
            $total['vac']         += $stub->vac_pay ;
            $total['overtime']    += $stub->overtime_qty * $stub->overtime_rate;
            $total['employee_cpp']         += $stub->cpp;
            $total['employee_ei']          += $stub->ei;
            $total['employer_cpp']         += $stub->employer_cpp;
            $total['employer_ei']          += $stub->employer_ei;
            $total['ftax']        += $stub->federal_tax;
        }
        $total['income'] = $total['hourly'] + $total['stat'] + $total['vac'] + $total['overtime'];
        $total['total_cpp'] = $total['employee_cpp'] + $total['employer_cpp'] ;
        $total['total_ei'] = $total['employee_ei'] + $total['employer_ei'] ;
        $total['total_deductions'] = $total['ftax'] + $total['total_cpp'] + $total['total_ei'];
        $total['employees'] = count($employees_list);

        $employer = Auth::user();
        // share data to view
        $data['name'] = 'test';
        view()->share('ytd','ytd');
        view()->share('total', $total);
        view()->share('employer', $employer);
        $pdf = PDF::loadView('dashboard.reports.pd7a_pdf', $data);

        // download PDF file with download method

        $file_name = $employer->name . '_'. $month . '_' . $year.'_pd7a.pdf';
        return $pdf->download($file_name);
    }

//    public function testtttt(){
//        return view('dashboard.reports.pd7a_pdf');
//    }

    public function pdoc($hourly, $vac_pay, $year, $month, $day, $employee_name, $employer_name, $province, $frequency){
        include(app_path() . '/pdoc/simple_html_dom.php');
        error_reporting(E_ALL); ini_set('display_errors', 1);
//        dd($hourly. ' '. $vac_pay. ' '. $year. ' '. $month. ' '. $day. ' '. $employee_name. ' '. $employer_name. ' '. $province. ' '. $frequency);
//        $hourly = '1088.27';
//        $vac_pay = '43.53';
//        $year = '2018';
//        $month = '11';
//        $day = '30';
//        $employee_name = 'test';
//        $employer_name = 'test';
//        $province = 'ALBERTA';
//        $frequency = 'SEMI_MONTHLY';
//
//        touch('cra-cookies.txt');

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
//            echo str_get_html($result);

            $hidden = $this->getHiddenFormValueFromHTML(str_get_html($result));
            $data['step0'] = array_merge($data['step0'], $hidden);


            // doing step 0 -> choose salary
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/welcome.action?request_locale=en_CA',
                    'post'  => http_build_query($data['step0'], '', '&'))
            );
//echo str_get_html($result);
            $hidden = $this->getHiddenFormValueFromHTML(str_get_html($result));
            $data['step1'] = array_merge($data['step1'], $hidden);
//
//
//            // doing step 1 name, province, date
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep1_fromWelcome.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep1_fromWelcome.action',
                    'post' => http_build_query($data['step1'], '', '&'))
            );

//            echo str_get_html($result);
            $hidden = $this->getHiddenFormValueFromHTML(str_get_html($result));
            $data['step2'] = array_merge($data['step2'], $hidden);

            // doing step 2 income, vacation
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep2a_fromPayrollDeductionsStep1.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep2a_fromPayrollDeductionsStep1.action',
                    'post' => http_build_query($data['step2'], '', '&'))
            );
//            echo str_get_html($result);

            $hidden = $this->getHiddenFormValueFromHTML(str_get_html($result));
            $data['step3'] = array_merge($data['step3'], $hidden);
////            echo 'data -----------------------------------------------';
////            print_r($data);
//
            // doing step 3
            $result = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep3_fromPayrollDeductionsStep2b.action",
                array(
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsStep3_fromPayrollDeductionsStep2b.action',
                    'post' => http_build_query($data['step3'], '', '&'))
            );
//            $hidden = $this->getHiddenFormValueFromHTML($result);
//            $data['step4'] = array_merge($data['step4'], $hidden);

            // step 4
            $result2 = $this->fetch("https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsRemittanceSummary_fromPayrollDeductionsResults.action",
                array(
//                    'hidden' => $hidden,
                    'refer' => 'https://apps.cra-arc.gc.ca/ebci/rhpd/prot/payrollDeductionsRemittanceSummary_fromPayrollDeductionsResults.action',
                    'post' => http_build_query($data['step4'], '', '&'))
            );
////            echo 'data ----------------------------------------------- <br/>';
////            print_r($data);
////            echo '<br />';
////            echo 'result ---------------------------------------------';
////            print_r($result);
////            echo 'result2 --------------------------------------------';
////            print_r($result2);
////            $hidden = $this->getHiddenFormValueFromHTML($result2);
//////            echo "<br> result: ------------------------------------------------------------";
//////            print_r($result);
//////            echo "<br>";
//////            echo "<br> result2: ------------------------------------------------------------";
//////            print_r($result2);
//////            echo "<br>";
////
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
//
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
//        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );/* NEW */
//        curl_setopt( $ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0" );
//        curl_setopt( $ch, CURLOPT_HEADER, 0 );
//        curl_setopt( $ch, CURLOPT_TIMEOUT, 500 );

        if( isset($z['post']) )         curl_setopt( $ch, CURLOPT_POSTFIELDS, $z['post'] );
        if( isset($z['refer']) )        curl_setopt( $ch, CURLOPT_REFERER, $z['refer'] );

        curl_setopt( $ch, CURLOPT_USERAGENT, $useragent );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 100 );
        curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cra-cookies.txt' );
        curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cra-cookies.txt' );

        $result = curl_exec( $ch );
        curl_close( $ch );

        return $result;
    }

    function getHiddenFormValueFromHTML($html) {
        foreach ($html->find("input[type=hidden]") as $node) {
            $hidden[$node->attr['name']] = $node->attr['value'];
        }
        return $hidden;
    }
}
