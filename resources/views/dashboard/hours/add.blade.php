@extends('layouts.dashboard')

@section('title')
    PDOC - Employee Hours
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Hours</li>
            <li class="breadcrumb-item active">Add Employee Hours</li>
        </ol>
        <div class="card mb-4">
{{--            <div class="card-header">Add Employee Hours</div>--}}
            <div class="card-body">
                <form method="POST" action="{{ route('add_employee_hours', ['id'=>$employee_id]) }}">
                    @csrf
                    <input type="hidden" value="{{ $employee_id }}" name="employee_id">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="work_date">Date</label>
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
                                <label class="small mb-1 required" for="work_hours">Work Hours </label>
                                <input class="form-control py-4 @error('work_hours') is-invalid @enderror" id="work_hours" type="text" name="work_hours" value="{{ old('work_hours') }}" required/>

                                @error('work_hours')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
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
                            <input id="over_time" class="custom-control-input @error('over_time') is-invalid @enderror" name="over_time" type="checkbox" />
                            <label class="custom-control-label" for="over_time">Is Over Time</label>
                            @error('over_time')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Add Employee Hour
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
