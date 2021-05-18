@extends('layouts.dashboard')

@section('title')
    PDOC - Employee Hours
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Reports</li>
            <li class="breadcrumb-item active">Settings</li>
        </ol>
        <div class="card mb-4">
            {{--            <div class="card-header">Add Employee Hours</div>--}}
            <div class="card-body">
                <form method="POST" action="{{ route('settings') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="stat">Stat Holiday </label>
                                <input class="form-control py-4 @error('stat') is-invalid @enderror" id="stat" type="text" name="stat" value="{{ $settings->stat_amount? $settings->stat_amount : old('stat') }}" required/>

                                @error('stat')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="overtime">Over Time</label>
                                <input class="form-control py-4 @error('overtime') is-invalid @enderror" id="overtime" type="text" name="overtime" value="{{ $settings->overtime_amount? $settings->overtime_amount :old('stat') }}" required/>

                                @error('overtime')
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
                                <label class="small mb-1" for="max_cpp">max CPP deduction amount</label>
                                <input class="form-control py-4 @error('max_cpp') is-invalid @enderror" id="max_cpp" type="text" name="max_cpp" value="{{ $settings->max_cpp? $settings->max_cpp :old('max_cpp') }}" required/>

                                @error('max_cpp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="max_ei">max EI deduction amount</label>
                                <input class="form-control py-4 @error('max_ei') is-invalid @enderror" id="max_ei" type="text" name="max_ei"  value="{{ $settings->max_ei? $settings->max_ei :old('max_ei') }}" required/>

                                @error('max_ei')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Update Settings
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
