<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HoursController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allEmployeesView($action){
        $employees = Employee::where('employer_id', Auth::id())->get();
        $frequencies = DB::table('frequency')->get();
        return view('dashboard.all_employees')
            ->with('employees', $employees)
            ->with('action', $action)
            ->with('frequencies', $frequencies);
    }

    public function addHours($id, Request $request){

        if ($request->method() == 'POST'){
            $validator = Validator::make($request->all(), [
                'pay_period' => 'required',
                'work_hours' => 'required|numeric|between:0,999.99',
//                'over_time' => 'numeric|between:0,99.99',
            ]);

            if ($validator->fails()) {
                return redirect(route('add_employee_hours', ['id' => $request->input('employee_id')]))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $hours = new Hour();
                $hours->work_date = $request->input('pay_period');
                $hours->work_hours = $request->input('work_hours');

                if ($request->input('stat_holiday') == 'on' && $request->input('over_time') == 'on') {
                    return redirect(route('add_employee_hours', ['id' => $request->input('employee_id')]))
                        ->with('error', 'please choose stat holiday or over time!');
                }
                if ($request->input('stat_holiday') == 'on') {
                    $hours->is_state_holiday = 1;
                }else {
                    $hours->is_state_holiday = 0;
                }
                if ($request->input('over_time') == 'on') {
                    $hours->is_over_time = 1;
                }else {
                    $hours->is_over_time = 0;
                }
                $hours->employee_id = $request->input('employee_id');
                $hours->employer_id = Auth::id();
                $hours->save();

                return redirect(route('add_employee_hours', ['id' => $request->input('employee_id')]))
                    ->with('msg', 'Adding Employee Hours Success!');
            }

        }else { // get method
            $employee = Employee::find($id);
            $frequency = DB::table('frequency')->where('option_value', $employee->pay_frequency)->first();
            return view('dashboard.hours.add')
                ->with('employee_id', $id)
                ->with('frequency', $frequency);
        }
    }

    public function hoursHistoryView($id, Request $request) {
        if ($request->method() == 'POST'){
            $employee_id = $request->input('employee_id');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $hours = Hour::where('employee_id', $employee_id)->whereBetween('work_date', [$from_date, $to_date])->get();
            return view('dashboard.hours.history')
//            ->with('employees', $employees)
                ->with('employee_id', $employee_id)
                ->with('hours_history', $hours)
                ->with('from_date', $from_date)
                ->with('to_date', $to_date);
        }else { // get method
            return view('dashboard.hours.history')
                ->with('employee_id', $id)
                ->with('hours_history', null)
                ->with('from_date', null)
                ->with('to_date', null);
        }
    }

}
