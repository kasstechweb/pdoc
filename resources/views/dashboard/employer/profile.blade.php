@extends('layouts.dashboard')

@section('title')
    PDOC - Add New Employer
@endsection

@section('content')

    <div class="container-fluid">
        <h1 class="mt-4">Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Account</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('update_profile') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="name">Employer Name</label>
                                <input class="form-control py-4 @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name')? old('name'): Auth::user()->name }}" />

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="province">Province of Employment</label>
                                <select name="province" id="province" class="form-control @error('province') is-invalid @enderror" id="province">
                                    <option value="">Select...</option>
                                    @foreach($provinces as $province)
                                        <option @if(old('province') == $province->id || Auth::user()->province_id == $province->id) selected @endif value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
{{--                                <input class="form-control py-4 @error('province') is-invalid @enderror" id="province" type="text" name="province" value="{{ old('province') }}"/>--}}

                                @error('province')
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
                                <label class="small mb-1" for="email">Employer email</label>
                                <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email')? old('email'): Auth::user()->email }}"/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="pbn">Employer Payroll Business Number</label>
                                <input class="form-control py-4 @error('pbn') is-invalid @enderror" id="pbn" type="text" name="pbn" value="{{ old('pbn')? old('pbn'): Auth::user()->pbn }}"/>

                                @error('pbn')
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
                        <label class="small mb-1" for="address">Employer Address</label>
                        <input class="form-control py-4 @error('address') is-invalid @enderror" id="address" type="text" aria-describedby="emailHelp" name="address" value="{{ old('address')? old('address'): Auth::user()->address }}" />

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Update Profile
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
