<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
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
                $employee->save();

                return redirect(route('add_new_employee'))
                    ->with('msg', 'Adding Employee Success!');
            }
        }else {
            return redirect(route('add_new_employee'));
        }
    }

    public function viewAllEmployees(){
        $employees = Employee::all();
        return view('dashboard.employee.view_all')
            ->with('employees', $employees);
    }
}
