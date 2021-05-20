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
            <li class="breadcrumb-item active">Store Employee Hours</li>
        </ol>
        <div class="card mb-4">
            {{--            <div class="card-header">Add Employee Hours</div>--}}
            <div class="card-body">
                <form method="POST" action="{{ route('pd7a') }}">
                    @csrf

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="month">Month</label>
                                {{--                                <input class="form-control py-4 @error('from_date') is-invalid @enderror" id="from_date" type="date" name="from_date" value="{{ $from_date?$from_date:''}}" required/>--}}
                                <select name="month" id="month" class="form-control @error('month') is-invalid @enderror" required>
                                    <option value="">Select...</option>
                                    @php
                                        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                        for ($i=0; $i < count($months); $i++) {
                                            $num = $i + 1;
                                            if (old('month') == str_pad($num, 2, '0', STR_PAD_LEFT)) {
                                                echo '<option selected value="'. str_pad($num, 2, '0', STR_PAD_LEFT) .'">'.$months[$i].'</option>';
                                            }else {
                                                echo '<option value="'. str_pad($num, 2, '0', STR_PAD_LEFT) .'">'.$months[$i].'</option>';
                                            }
                                        }
                                    @endphp
{{--                                    @foreach($frequencies as $frequency)--}}
{{--                                        <option @if($freq == $frequency->option_value) selected @endif value="{{ $frequency->option_value }}">{{ $frequency->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>

                                @error('month')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="year">Year</label>
                                {{--                                <input class="form-control py-4 @error('from_date') is-invalid @enderror" id="from_date" type="date" name="from_date" value="{{ $from_date?$from_date:''}}" required/>--}}
                                <select name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
                                    <option value="">Select...</option>
                                    @php
                                        $year = now()->year;
                                        while ($year != 2017) {
                                            if (old('year') == $year) {
                                                echo '<option selected value="'.$year.'">'.$year.'</option>';
                                            }else {
                                                echo '<option value="'.$year.'">'.$year.'</option>';
                                            }
                                            $year--;
                                        }
                                    @endphp
{{--                                    @foreach($frequencies as $frequency)--}}
{{--                                        <option @if($freq == $frequency->option_value) selected @endif value="{{ $frequency->option_value }}">{{ $frequency->name }}</option>--}}
{{--                                    @endforeach--}}
                                </select>

                                @error('year')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Show PD7A Report
                        </button>
                        {{--                        <a class="btn btn-primary btn-block" href="login.html">Add New Employee</a>--}}
                    </div>
                </form>
{{--                total: {{ var_dump($total)  }}--}}
                @if(Session::get('total') != null)
                <hr>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Gross payroll for period
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['income'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        No. of employees paid in period
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['employees'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tax deductions
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['ftax'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total CPP contributions - Employee
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['employee_cpp'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total CPP contributions - Company
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['employer_cpp'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total CPP contributions
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['total_cpp'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total EI premiums - Employee
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['employee_ei'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total EI premiums - Company
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['employer_ei'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total EI premiums
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['total_ei'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Remittance for period
                        <span class="badge badge-primary badge-pill">{{number_format(Session::get('total')['total_deductions'], 2)}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a onclick="print_pd7a({{old('month')}}, {{old('year')}})" class="btn btn-success btn-block" id="btn_text_download" href="javascript:void(0);">
                        <span>
                             <i class="fas fa-download"></i>
                            Download Paystub
                        </span>
                        </a>
                    </li>
                </ul>

                @endif
            </div>
        </div>
    </div>

@endsection

@section('after_load')
    <script type="text/javascript">
        function print_pd7a(month, year){
            console.log('clicked')
            var get_request = 'month=' + month;
            get_request += '&year=' + year;

            window.open('/pd7apdf?' + get_request, '_blank')
        }
    </script>

@endsection
