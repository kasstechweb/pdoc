@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Employer Account</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1 required" for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" class="py-4 form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="small mb-1 required" for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="py-4 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 required" for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="py-4 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 required" for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control py-4" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 required" for="province">Province of Employment</label>
                                    <select name="province" id="province" class="form-control @error('province') is-invalid @enderror" id="province" required>
                                        <option value="">Select...</option>
                                        {{$provinces = DB::table('provinces')->get()}}
                                        @foreach($provinces as $province)
                                            <option @if(old('province') == $province->id) selected @endif value="{{ $province->id }}">{{ $province->name }}</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1 required" for="pbn">Employer Payroll Business Number</label>
                                    <input class="form-control py-4 @error('pbn') is-invalid @enderror" id="pbn" type="text" name="pbn" value="{{ old('pbn') }}" required/>

                                    @error('pbn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small mb-1 required" for="address">Employer Address</label>
                            <input class="form-control py-4 @error('address') is-invalid @enderror" id="address" type="text" aria-describedby="emailHelp" name="address" value="{{ old('address') }}" required />

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>


                        <div class="form-group mt-4 mb-0">
                            <button type="submit" class="btn btn-primary btn-block">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
