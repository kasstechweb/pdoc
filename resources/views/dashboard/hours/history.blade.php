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
            <li class="breadcrumb-item active">View Employee Hours History</li>
        </ol>
        <div class="card mb-4">
            {{--            <div class="card-header">Add Employee Hours</div>--}}
            <div class="card-body">
                <form method="POST" action="{{ route('view_employee_hours', ['id' => $employee_id]) }}">
                    @csrf
                    <input type="hidden" value="{{ $employee_id }}" name="employee_id">

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="from_date">From Date</label>
                                <input class="form-control py-4 @error('from_date') is-invalid @enderror" id="from_date" type="date" name="from_date" value="{{ $from_date?$from_date:''}}" required/>

                                @error('from_date')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1 required" for="to_date">To Date</label>
                                <input class="form-control py-4 @error('to_date') is-invalid @enderror" id="to_date" type="date" name="to_date" value="{{ $to_date?$to_date:'' }}" required/>

                                @error('to_date')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            View Hours History
                        </button>
                        {{--                        <a class="btn btn-primary btn-block" href="login.html">Add New Employee</a>--}}
                    </div>
                </form>

                <hr>

                @if($hours_history != null)
                    <table class="table">
                        @php $total_hours = 0; $total_stat_hours=0; $total_overtime_hours=0; @endphp
                        @foreach($hours_history as $history)
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">
                                    Day: {{ $history->work_date->format('l') }}
                                    @if($history->is_state_holiday)
                                        <span class="badge px-2 py-1 {{ $history->is_state_holiday? 'badge-success' : '' }} badge-pill">
                                        Stat Holiday
                                    </span>
                                    @endif
                                    @if($history->is_over_time)
                                        <span class="badge px-2 py-1 {{ $history->is_over_time? 'badge-success' : '' }} badge-pill">
                                        Over Time
                                    </span>
                                    @endif

                                </th>
                                <th scope="col">Date: {{ $history->work_date->format('Y-m-d') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    Hours: {{ $history->work_hours }}
{{--                                    sta {{$history->is_state_holiday}}--}}
{{--                                    ot: {{$history->is_over_time}}--}}
                                    @php
                                        if ($history->is_state_holiday == 1){
                                            $total_stat_hours += $history->work_hours;
                                        }elseif ($history->is_over_time == 1){
                                            $total_overtime_hours += $history->work_hours;
                                        }else {
                                            $total_hours += $history->work_hours;
                                        }
                                    @endphp

                                    <br>
                                    OverTime Hours: {{ $history->over_time_hours? $history->over_time_hours : '0.0' }}
                                </td>
                                <td></td>
                            </tr>
                            </tbody>

                        @endforeach
                    </table>
                    <hr>
                    <div class="bg-success text-white px-2 py-2">
                        <div class="row">
                            <div class="col-sm">Total Hours: {{$total_hours}}</div>
                            <div class="col-sm">Stat Holiday Hours: {{ $total_stat_hours }}</div>
                            <div class="col-sm">OverTime Hours: {{ $total_overtime_hours }}</div>
                        </div>

                        @php
                            function convertTime($dec){
                                // start by converting to seconds
                                $seconds = ($dec * 3600);
                                // we're given hours, so let's get those the easy way
                                $hours = floor($dec);
                                // since we've "calculated" hours, let's remove them from the seconds variable
                                $seconds -= $hours * 3600;
                                // calculate minutes left
                                $minutes = floor($seconds / 60);
                                // remove those from seconds as well
                                $seconds -= $minutes * 60;
                                // return the time formatted HH:MM:SS
                                //return lz($hours).":".lz($minutes).":".lz($seconds);
                                return lz($hours).":".lz($minutes);
                            }

                            // lz = leading zero
                            function lz($num){return (strlen($num) < 2) ? "0{$num}" : $num;}

                        echo '<div class="row">';
                        echo '<div class="col-sm">Total Hours: '. convertTime($total_hours). '</div><div class="col-sm">' .'Stat Holiday Hours: '.convertTime($total_stat_hours). '</div><div class="col-sm">OverTime Hours: '.convertTime($total_overtime_hours). '</div>';
                        echo '</div></div>';
                        @endphp
                    </div>
                @endif
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
