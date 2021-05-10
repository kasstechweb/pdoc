@extends('layouts.dashboard')

@section('title')
    PDOC - Add New Employee
@endsection

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Add New Employee</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Add New Employee</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="inputFirstName">Employee SIN #</label>
                                <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="inputLastName">Employee Name</label>
                                <input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="inputEmailAddress">Employee Address</label>
                        <input class="form-control py-4" id="inputEmailAddress" type="text" aria-describedby="emailHelp" placeholder="Enter email address" />
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="ei_exempt" type="checkbox" />
                            <label class="custom-control-label" for="ei_exempt">Is Employee EI exempt</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="cpp_exempt" type="checkbox" />
                            <label class="custom-control-label" for="cpp_exempt">Is Employee CPP exempt</label>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" href="login.html">Add New Employee</a></div>
                </form>
            </div>
        </div>
    </div>

@endsection
