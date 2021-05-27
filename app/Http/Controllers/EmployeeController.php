<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Hour;
use App\Models\Paystub;
use Illuminate\Database\Eloquent\Model;
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
                if ($request->input('termination_date') != null) {
                    $employee->termination_date = $request->input('termination_date');
                }else {
                    $employee->termination_date = '3001-12-31';
                }
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

    public function updateEmployee($id, Request $request){
        if ($request->method() == 'POST') {
            $messages = [
                'sin.required' => 'Social Insurance Number is required.',
                'sin.unique' => 'this Social Insurance Number is taken.',
            ];

            $validator = Validator::make($request->all(), [
                'sin' => 'required',
                'name' => 'required',
                'hire_date' => 'required',
                'address' => 'required',
                'pay_rate' => 'required|numeric|between:0,99.99',
            ], $messages);

            if ($validator->fails()) {
//                return 'fail';
                return redirect(route('update_employee', ['id'=>$id]))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $employee = Employee::find($id);
                $employee->sin = $request->input('sin');
                $employee->name = $request->input('name');
//            $employee->email = $request->input('email');
//            $employee->phone = $request->input('phone');
                $employee->address = $request->input('address');
                $employee->hire_date = $request->input('hire_date');
                if ($request->input('termination_date') != null) {
                    $employee->termination_date = $request->input('termination_date');
                }else {
                    $employee->termination_date = '3001-12-31';
                }
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

                return redirect(route('update_employee', ['id'=>$id]))
                    ->with('msg', 'Updating Employee Success!');
            }
        }else {
            $employee = Employee::find($id);
            return view('dashboard.employee.update')
                ->with('employee', $employee);
        }

    }

    public function deleteEmployee($id){
        // delete hours first
        $hours = Hour::where('employee_id', $id)->get();
        Hour::destroy($hours);
        $paystubs = Paystub::where('employee_id', $id)->get();
        Paystub::destroy($paystubs);
        $employee  = Employee::find($id);
        $employee->delete();
        return redirect(route('view_all_employees', ['action' => 'view_all']))
            ->with('msg', 'Deleting Employee Success!');
    }


}
