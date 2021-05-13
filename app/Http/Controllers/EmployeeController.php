<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addNewEmployee() {
        return view('dashboard.employee.add');
    }


    public function storeNewEmployee(Request $request){
        $messages = [
            'sin.required' => 'Social Insurance Number is required.',
            'sin.unique' => 'this Social Insurance Number is taken.',
        ];

        if ($request->method() == 'POST'){
            $validator = Validator::make($request->all(), [
                'sin' => 'required|unique:employees',
                'name' => 'required',
                'hire_date' => 'required',
                'termination_date' => 'required',
                'address' => 'required',
                'pay_rate' => 'required|numeric|between:0,99.99',
            ], $messages);

            if ($validator->fails()) {
                return redirect(route('add_new_employee'))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $employee = new Employee();
                $employee->sin = $request->input('sin');
                $employee->name = $request->input('name');
//            $employee->email = $request->input('email');
//            $employee->phone = $request->input('phone');
                $employee->address = $request->input('address');
                $employee->hire_date = $request->input('hire_date');
                $employee->termination_date = $request->input('termination_date');
                $employee->pay_rate = $request->input('pay_rate');
                // changing checkbox on to boolean
                if ($request->input('ei_exempt') == 'on') {
                    $employee->ei_exempt = 1;
                }else {
                    $employee->ei_exempt = 0;
                }
                if ($request->input('cpp_exempt') == 'on') {
                    $employee->cpp_exempt = 1;
                }else {
                    $employee->cpp_exempt = 0;
                }

                $employee->employer_id = auth()->id();
                $employee->save();

                return redirect(route('add_new_employee'))
                    ->with('msg', 'Adding Employee Success!');
            }
        }else {
            return redirect(route('add_new_employee'));
        }
    }

//    public function viewAllEmployees(){
//        $employees = Employee::all();
//        return view('dashboard.employee.view_all')
//            ->with('employees', $employees);
//    }

    public function employeeHours($id){
//        $employees = Employee::all();
        return view('dashboard.employee.hours')
//            ->with('employees', $employees)
            ->with('employee_id', $id)
            ->with('hours_history', null)
            ->with('from_date', null)
            ->with('to_date', null);
    }

    public function employeeHoursHistory(Request $request){
        $employee_id = $request->input('employee_id');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $hours = Hour::where('employee_id', $employee_id)->whereBetween('work_date', [$from_date, $to_date])->get();
        return view('dashboard.employee.hours')
//            ->with('employees', $employees)
            ->with('employee_id', $employee_id)
            ->with('hours_history', $hours)
            ->with('from_date', $from_date)
            ->with('to_date', $to_date);
//        dd($hours);
//        $employees = Employee::all();
//        return view('dashboard.employee.hours')
//            ->with('employees', $employees)
//            ->with('employee_id', $id);
    }

//    public function storeEmployeeHours(Request $request) {
//        if ($request->method() == 'POST') {
//            $validator = Validator::make($request->all(), [
//                'work_date' => 'required',
//                'work_hours' => 'required|numeric|between:0,99.99',
////                'over_time' => 'numeric|between:0,99.99',
//            ]);
//
//            if ($validator->fails()) {
//                return redirect(route('employee_hours', ['id' => $request->input('employee_id')]))
//                    ->withErrors($validator)
//                    ->withInput();
//            }else { // pass validation
//                $hours = new Hour();
//                $hours->work_date = $request->input('work_date');
//                $hours->work_hours = $request->input('work_hours');
//                if ($request->input('stat_holiday') == 'on') {
//                    $hours->is_state_holiday = 1;
//                }else {
//                    $hours->is_state_holiday = 0;
//                }
//                if ($request->input('over_time') == 'on') {
//                    $hours->is_over_time = 1;
//                }else {
//                    $hours->is_over_time = 0;
//                }
//                $hours->employee_id = $request->input('employee_id');
//                $hours->employer_id = Auth::id();
//                $hours->save();
//
//                return redirect(route('view_all_employees'))
//                    ->with('msg', 'Adding Employee Hours Success!');
//            }
//
//        }else {
//            return redirect(route('view_all_employees'));
//        }
//    }


}
