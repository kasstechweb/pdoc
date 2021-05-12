<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    public function viewProfile() {
        $provinces = DB::table('provinces')->get();
        return view('dashboard.employer.profile')
            ->with('provinces', $provinces);
    }

    public function updateProfile(Request $request){
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
                return redirect(route('profile'))
                    ->withErrors($validator)
                    ->withInput();
            }else { // pass validation
                $employer = User::find(Auth::id());
                $employer->name = $request->input('name');
                $employer->address = $request->input('address');
                $employer->pbn = $request->input('pbn');
                $employer->province_id = $request->input('province');

                $employer->save();

                return redirect(route('profile'))
                    ->with('msg', 'Updating Profile Success!');
            }
        }else {
            return redirect(route('profile'));
        }
    }

    public function viewAllEmployers(){

    }
}
