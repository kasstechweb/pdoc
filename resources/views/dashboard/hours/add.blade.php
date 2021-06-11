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
                <h6>Payment Frequency: {{ $frequency->name }}</h6>
                <form method="POST" action="{{ route('add_employee_hours', ['id'=>$employee_id]) }}">
                    @csrf
                    <input type="hidden" value="{{ $employee_id }}" name="employee_id">
                    <input id="frequency" type="hidden" value="{{ $frequency->option_value }}">
                    <div class="form-row">
                        @if($frequency->option_value == 'DAILY')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="month">Month</label>
                                <select onchange="calculatePeriod('{{ $frequency->option_value }}');" name="month" id="month" class="form-control @error('month') is-invalid @enderror" required>
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
                                </select>

                                @error('month')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="year">Year</label>
                                <select onchange="calculatePeriod('{{ $frequency->option_value }}');" name="year" id="year" class="form-control @error('year') is-invalid @enderror" required>
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
                                </select>

                                @error('year')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="pay_period">Pay period</label>
                                <select name="pay_period" id="pay_period" class="form-control @error('pay_period') is-invalid @enderror" required>
                                    <option value="">Select month and year above</option>
                                    {{--                                    <option value="2021-01-15">1: 2021-01-01 to 2021-01-15</option>--}}
                                </select>

                                @error('year')
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
                                <label class="small mb-1 required" for="work_hours">Work Hours </label>
                                <input class="form-control py-4 @error('work_hours') is-invalid @enderror" id="work_hours" type="text" name="work_hours" value="{{ old('work_hours') }}" required/>

                                @error('work_hours')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="col-md-6">--}}


{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="form-row">
                        <div class="col-md-2">
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
                        </div>
                            <div class="col-md-2">
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
                            </div>
                    </div>

{{--                    <div class="form-row">--}}
{{--                        <div class="col">--}}
{{--                            <div class="form-group">--}}
{{--                                <input class="form-control py-4" id="pay_period" type="text" aria-describedby="emailHelp" name="pay_period" value="Choose date above to show pay period" disabled/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-checkbox">--}}
{{--                            <input class="custom-control-input @error('stat_holiday') is-invalid @enderror" id="stat_holiday" type="checkbox" name="stat_holiday" {{ old('stat_holiday') ? 'checked' : '' }} />--}}
{{--                            <label class="custom-control-label" for="stat_holiday">Is Stat Holiday</label>--}}
{{--                            @error('stat_holiday')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-checkbox">--}}
{{--                            <input id="over_time" class="custom-control-input @error('over_time') is-invalid @enderror" name="over_time" type="checkbox" />--}}
{{--                            <label class="custom-control-label" for="over_time">Is Over Time</label>--}}
{{--                            @error('over_time')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

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
    <script type="text/javascript">
        function calculatePeriod(option_value){
            // const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            var pay_period = document.getElementById('pay_period');

            var normal_year =  [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            var leap_year=  [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            const zeroPad = (num, places) => String(num).padStart(places, '0')

            if (year !== ''){
                console.log(isLeap(year));
                console.log(option_value);
                var options = '';
                switch (option_value) {
                    case 'DAILY':
                        var month = document.getElementById('month').value;
                        if (!isLeap(year)){
                            for (var i = 1; i <= normal_year[month-1]; i++) {
                                var start_date = new Date(year + '-' + month + '-' + zeroPad(i, 2));
                                start_date = start_date.toLocaleDateString("en-CA");
                                options += '<option value="' + start_date +'"> '+ start_date ;
                            }
                        }else if(isLeap(year)) {
                            for (var i = 1; i <= leap_year[month-1]; i++) {
                                var start_date = new Date(year + '-' + month + '-' + zeroPad(i, 2));
                                start_date = start_date.toLocaleDateString("en-CA");
                                options += '<option value="' + start_date +'"> '+ start_date ;
                            }
                        }

                        pay_period.innerHTML = options;
                        break;
                    case 'WEEKLY_52PP':
                        for (var i = 1; i <= 52; i++) {
                            var end_date = new Date(year + '-' + '01-01');
                            end_date.setDate((end_date.getDate() + (7 * i)) - 1);
                            end_date = end_date.toLocaleDateString("en-CA");

                            var start_date = new Date(end_date);
                            start_date.setDate((start_date.getDate() - 7 ) + 1);
                            start_date = start_date.toLocaleDateString("en-CA");

                            options += '<option value="' + end_date +'"> '+ zeroPad(i, 2) + ': ' + start_date + ' to ' + end_date ;
                            // console.log(i + ' start date: ' + start_date + ' end date: ' + end_date)
                        }
                        pay_period.innerHTML = options;
                        break;
                    case 'BI_WEEKLY':
                        for (var i = 1; i <= 26; i++) {
                            var end_date = new Date(year + '-' + '01-01');
                            end_date.setDate((end_date.getDate() + (14 * i)) - 1);
                            end_date = end_date.toLocaleDateString("en-CA");

                            var start_date = new Date(end_date);
                            start_date.setDate((start_date.getDate() - 14 ) + 1);
                            start_date = start_date.toLocaleDateString("en-CA");

                            options += '<option value="' + end_date +'"> '+ zeroPad(i, 2) + ': ' + start_date + ' to ' + end_date ;
                            // console.log(i + ' start date: ' + start_date + ' end date: ' + end_date)
                        }
                        pay_period.innerHTML = options;
                        break;
                    case 'SEMI_MONTHLY':
                        for (var i = 1; i <= 12; i++) {
                            var start_date = year + '-' + zeroPad(i, 2) + '-01';
                            var middle_date = year + '-' + zeroPad(i, 2) + '-15';
                            var start_date2 = year + '-' + zeroPad(i, 2) + '-16';
                            if (!isLeap(year)) {
                                var end_date = year + '-' + zeroPad(i, 2) + '-' + normal_year[parseInt(i-1)];
                            }else if(isLeap(year)) {
                                var end_date = year + '-' + zeroPad(i, 2) + '-' + leap_year[parseInt(i-1)];
                            }
                            options += '<option value="' + middle_date +'"> '+ zeroPad(2*i-1, 2) + ': ' + start_date + ' to ' + middle_date ;
                            options += '<option value="' + end_date +'">'+ zeroPad(2*i, 2) + ': ' + start_date2 + ' to ' + end_date ;
                        }
                        pay_period.innerHTML = options;
                        break;
                    case 'MONTHLY_12PP':
                        for (var i = 1; i <= 12; i++) {
                            var start_date = year + '-' + zeroPad(i, 2) + '-01';
                            if (!isLeap(year)) {
                                var end_date = year + '-' + i + '-' + normal_year[parseInt(i-1)];
                            }else if(isLeap(year)) {
                                var end_date = year + '-' + i + '-' + leap_year[parseInt(i-1)];
                            }
                            options += '<option value="' + end_date +'"> '+ zeroPad(i, 2) + ': ' + start_date + ' to ' + end_date ;
                        }
                        pay_period.innerHTML = options;
                        break;

                    default:
                        break;
                }
            }
        }
        function isLeap(year) {
            return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
        }
        // function showPeriod(){
        //     var work_date = document.getElementById('work_date');
        //     var freq = document.getElementById('frequency').value;
        //     var work_date = document.getElementById('work_date').value;
        //     var pay_period = document.getElementById('pay_period');
        //     // console.log(work_date);
        //     // calculate number of days based on frequency
        //     var days_num = 0;
        //     switch (freq) {
        //         case 'DAILY':
        //             days_num = 1;
        //             break;
        //         case 'WEEKLY_52PP':
        //             days_num = 7;
        //             break;
        //         case 'BI_WEEKLY':
        //             days_num = 14;
        //             break;
        //         case 'SEMI_MONTHLY':
        //             days_num = 15;
        //             break;
        //         case 'MONTHLY_12PP':
        //             days_num = 30;
        //             break;
        //         case 'WEEKLY_53PP':
        //             days_num = 7;
        //             break;
        //         case 'BI_WEEKLY_27PP':
        //             days_num = 14;
        //             break;
        //         default:
        //             days_num = 0;
        //     }
        //     // console.log('days_num ', days_num);
        //     // console.log('freq ', freq);
        //
        //     var first_date = new Date(work_date);
        //     first_date.setDate((first_date.getDate() - days_num) + 1);
        //     first_date = first_date.toLocaleDateString("en-CA");
        //
        //     pay_period.value = 'Payment period starting on: ' + first_date + ' and ending on: ' + work_date;
        //     // console.log('first date: ' + first_date)
        // }
    </script>
    @if(Session::get('msg'))
        <script type="text/javascript">
            showSuccess("{{Session::get('msg')}}");
        </script>
    @elseif(Session::get('error'))
        <script type="text/javascript">
            showErrorMessage("{{Session::get('error')}}");
        </script>
    @else
        <!--<script type="text/javascript">
                console.log('no msg');
                showSuccess('no msg');
            </script>-->
    @endif
@endsection
