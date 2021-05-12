@extends('layouts.dashboard')

@section('title')
    PDOC - Employee Hours
@endsection

@section('header')
    <script type="text/javascript">
            function showOverTimeInput(id) {
                console.log('clicked');
                if ($('#' + id).hasClass('d-none')){
                    $('#' + id).removeClass('d-none');
                }else {
                    $('#' + id).addClass('d-none');
                }
                // var input = document.getElementById('overTimeInput');
                // input.style.display = 'block';
            }
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Employee Hours</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Employee</li>
            <li class="breadcrumb-item active">Employee Hours</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('store_employee_hours') }}">
                    @csrf
                    <input type="hidden" value="{{ $employee_id }}" name="employee_id">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="work_date">Date</label>
                                <input class="form-control py-4 @error('work_date') is-invalid @enderror" id="work_date" type="date" name="work_date" value="{{ old('work_date') }}" required/>

                                @error('work_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="work_hours">Work Hours </label>
                                <input class="form-control py-4 @error('work_hours') is-invalid @enderror" id="work_hours" type="text" name="work_hours" value="{{ old('work_hours') }}" required/>

                                @error('work_hours')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input @error('stat_holiday') is-invalid @enderror" id="stat_holiday" type="checkbox" name="stat_holiday" {{ old('stat_holiday') ? 'checked' : '' }} />
                            <label class="custom-control-label" for="stat_holiday">Is Stat Holiday</label>
                            @error('stat_holiday')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input onclick="showOverTimeInput('overTimeInput')" id="over_time_check" class="custom-control-input @error('over_time') is-invalid @enderror" type="checkbox" />
                            <label class="custom-control-label" for="over_time_check">Has Over Time</label>
                            @error('over_time')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div id="overTimeInput" class="form-group d-none">
                        <label class="small mb-1" for="over_time">Employee Over Time </label>
                        <input class="form-control py-4" id="over_time" type="text" name="over_time" value="{{ old('over_time') }}" />
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Add Employee Hour
                        </button>
                        {{--                        <a class="btn btn-primary btn-block" href="login.html">Add New Employee</a>--}}
                    </div>
                </form>
                <hr>

{{--                <table id="example" class="display nowrap" cellspacing="0" width="100%">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th></th>--}}
{{--                        <th>#</th>--}}
{{--                        <th>name</th>--}}
{{--                        <th>Hire Date</th>--}}
{{--                        <th>Termination Date</th>--}}
{{--                        <th>SIN #</th>--}}
{{--                        <th></th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($employees as $employee)--}}
{{--                        <tr data-child-value="{{ $employee->address }}">--}}
{{--                            <td class="details-control"></td>--}}
{{--                            <td>{{ $employee->id }}</td>--}}
{{--                            <td>{{ $employee->name }}</td>--}}
{{--                            <td>{{ $employee->hire_date }}</td>--}}
{{--                            <td>{{ $employee->termination_date }}</td>--}}
{{--                            <td>{{ $employee->sin }}</td>--}}
{{--                            <td class="m-auto">--}}
{{--                                <a class="btn btn-success" href="{{ route('employee_hours', ['id' => $employee->id]) }}">--}}
{{--                                    <i class="far fa-clock"></i>--}}
{{--                                </a>--}}
{{--                                <a class="btn btn-primary">--}}
{{--                                    <i class="fas fa-pen"></i>--}}
{{--                                </a>--}}
{{--                                <a class="btn btn-danger">--}}
{{--                                    <i class="fas fa-trash-alt"></i>--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}

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
