<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use App\Models\Paystub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function viewHome(){
        $employer_id = Auth::id();

        $employees = Employee::where('employer_id', $employer_id)->get();
        $employees_count  = $employees->count();

        $hours = Hour::where('employer_id', $employer_id)->sum('work_hours');

        // get year to date data
        $totals = Paystub::where('employer_id', '=', Auth::id())->get();

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


        $count['employees'] = $employees_count;
        $count['hours'] = $hours;
        $count['income'] = $total['income'];
        $count['remittance'] = $total['total_deductions'];

        $incomes = array();
        $remittances = array();
        $employees_num = array();

        for ($i=0; $i< 12; $i++) {
            $month = str_pad($i+1, 2, '0', STR_PAD_LEFT);
            $date_start = now()->year . '-'. $month . '-01';
            $date_end = now()->year . '-'. $month . '-31';
//            // get year to date data
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

            $dateS = new Carbon($date_start);
            $dateE = new Carbon($date_end);
            $employees = Employee::where('employer_id', $employer_id)->whereBetween('created_at', [$dateS, $dateE])->get();
            $employees_count = $employees->count();

            array_push($incomes, $total['income']);
            array_push($remittances, $total['total_deductions']);
            array_push($employees_num, $employees_count);

        }
//        dd($remittances);
        return view('dashboard.home')
            ->with('count', $count)
            ->with('incomes', $incomes)
            ->with('remittances', $remittances)
            ->with('employees_num', $employees_num);
    }
}
