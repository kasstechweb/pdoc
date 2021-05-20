@extends('layouts.dashboard')

@section('title')
    PDOC - Add New Employee
@endsection

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Add New Employee</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Employee</li>
            <li class="breadcrumb-item active">Add New Employee</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('store_new_employee') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="sin">Employee Social Insurance Number </label>
                                <input class="form-control py-4 @error('sin') is-invalid @enderror" id="sin" type="text" name="sin" value="{{ old('sin') }}" required/>

                                @error('sin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="name">Employee Name</label>
                                <input class="form-control py-4 @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required/>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
<!--
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="email">Employee Email</label>
                                <input class="form-control py-4" id="email" type="text" name="email" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="phone">Employee Phone</label>
                                <input class="form-control py-4" id="phone" type="text" name="phone" />
                            </div>
                        </div>
                    </div>
-->

                    <div class="form-group">
                        <label class="small mb-1 required" for="address">Employee Address</label>
                        <input class="form-control py-4 @error('address') is-invalid @enderror" id="address" type="text" aria-describedby="emailHelp" name="address" value="{{ old('address') }}" required/>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="hire">Employee Hire Date</label>
                                <input class="form-control py-4 @error('hire_date') is-invalid @enderror" id="hire" type="date" name="hire_date" value="{{ old('hire_date') }}" required/>

                                @error('hire_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="termination_date">Employee Termination Date</label>
                                <input class="form-control py-4 @error('termination_date') is-invalid @enderror" id="termination_date" type="date" name="termination_date"  value="{{ old('termination_date') }}" required/>

                                @error('termination_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="pay_rate">Employee Pay Rate</label>
                                <input class="form-control py-4 @error('pay_rate') is-invalid @enderror" id="pay_rate" type="text" name="pay_rate" value="{{ old('pay_rate') }}" required/>

                                @error('pay_rate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input @error('ei_exempt') is-invalid @enderror" id="ei_exempt" type="checkbox" name="ei_exempt" {{ old('ei_exempt') ? 'checked' : '' }}/>
                            <label class="custom-control-label" for="ei_exempt">Is Employee EI exempt</label>
                            @error('ei_exempt')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input @error('cpp_exempt') is-invalid @enderror" id="cpp_exempt" type="checkbox" name="cpp_exempt"  {{ old('cpp_exempt') ? 'checked' : '' }}/>
                            <label class="custom-control-label" for="cpp_exempt">Is Employee CPP exempt</label>
                            @error('cpp_exempt')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Add New Employee
                        </button>
{{--                        <a class="btn btn-primary btn-block" href="login.html">Add New Employee</a>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('after_load')
    @if(Session::get('msg'))
        <script type="text/javascript">
            showSuccess("{{Session::get('msg')}}");
        </script>
    @else
        <!--<script type="text/javascript">
            console.log('no msg');
            showSuccess('no msg');
        </script>-->
    @endif
@endsection
