<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HoursController extends Controller
{
    public function allEmployeesView($action){
        $employees = Employee::all();
        return view('dashboard.all_employees')
            ->with('employees', $employees)
            ->with('action', $action);
    }

    public function addHours($id, Request $request){

        if ($request->method() == 'POST'){
            $validator = Validator::make($request->all(), [
                'work_date' => 'required',
                'work_hours' => 'required|numeric|between:0,99.99',
//                'over_time' => 'numeric|between:0,99.99',
            ]);

            if ($validator->fails()) {
                return redirect(route('add_employee_hours', ['id' => $request->input('employee_id')]))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $hours = new Hour();
                $hours->work_date = $request->input('work_date');
                $hours->work_hours = $request->input('work_hours');
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
            return view('dashboard.hours.add')
                ->with('employee_id', $id);
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

    public function getHoursHistory(){

    }

}
