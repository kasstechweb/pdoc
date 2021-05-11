<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    public function addNewEmployer() {
        $provinces = DB::table('provinces')->get();
        return view('dashboard.employer.add')
            ->with('provinces', $provinces);
    }

    public function storeNewEmployer(Request $request){
        $messages = [
            'pbn.required' => 'Payroll Business Number is required.',
        ];

        if ($request->method() == 'POST'){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'province' => 'required',
                'pbn' => 'required',
                'address' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect(route('add_new_employer'))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $employer = new Employer();
                $employer->name = $request->input('name');
                $employer->address = $request->input('address');
                $employer->pbn = $request->input('pbn');
                $employer->province_id = $request->input('province');

                $employer->save();

                return redirect(route('add_new_employer'))
                    ->with('msg', 'Adding Employer Success!');
            }
        }else {
            return redirect(route('add_new_employer'));
        }
    }
}
