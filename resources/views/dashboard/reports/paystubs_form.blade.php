@extends('layouts.dashboard')

@section('title')
    PDOC - Employee Hours
@endsection

@section('header')
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">
    <style>
        td.details-control {
            background: url('{{ asset('img/details_open.png') }}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ asset('img/details_close.png') }}') no-repeat center center;
        }
    </style>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/dataTables.bootstrap.css') }}"/>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4"></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Reports</li>
            <li class="breadcrumb-item active">
                Paystubs
            </li>
        </ol>
        <div class="card mb-4">
            {{--            <div class="card-header">Add Employee Hours</div>--}}
            <div class="card-body table-responsive">
                <form method="POST" action="{{ route('paystubs_form') }}">
                    @csrf

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="frequency">Pay Frequency</label>
{{--                                <input class="form-control py-4 @error('from_date') is-invalid @enderror" id="from_date" type="date" name="from_date" value="{{ $from_date?$from_date:''}}" required/>--}}
                                <select name="frequency" id="frequency" class="form-control @error('frequency') is-invalid @enderror" id="province" required>
                                    <option value="">Select...</option>
                                    @foreach($frequencies as $frequency)
                                        <option @if($freq == $frequency->option_value) selected @endif value="{{ $frequency->option_value }}">{{ $frequency->name }}</option>
                                    @endforeach
                                </select>

                                @error('from_date')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" for="payment_date">Payment Date</label>
                                <input class="form-control py-4 @error('payment_date') is-invalid @enderror" id="payment_date" type="date" name="payment_date" value="{{ $payment_date?$payment_date:'' }}" required/>

                                @error('payment_date')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row d-flex justify-content-center">
                        <div class="col-md-4">
                            <a onclick="payPeriod()" class="btn btn-success">calculate pay period</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small mb-1" for="pay_period">Pay Period</label>
                        <input class="form-control py-4" id="pay_period" type="text" aria-describedby="emailHelp" name="pay_period" value="..." disabled/>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            Show Employees
                        </button>
                        {{--                        <a class="btn btn-primary btn-block" href="login.html">Add New Employee</a>--}}
                    </div>
                </form>

                <hr />
{{--                <div class="d-flex justify-content-center">--}}
{{--                    <div id="spinner"  class="spinner-border" style="display: none;" role="status">--}}
{{--                        <span class="sr-only">Loading...</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
                @if($employees != null)
                    <table id="employees_table" class="display nowrap " cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>name</th>
                            {{--                        <th>Hire Date</th>--}}
                            {{--                        <th>Termination Date</th>--}}
                            <th>SIN #</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr data-child-value="
                                Address: {{ $employee->address }} <br>
                                Hire Date: {{ $employee->hire_date }} <br>
                                Termination Date: {{ $employee->termination_date }}">
                                <td class="details-control"></td>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                                {{--                            <td>{{ $employee->hire_date }}</td>--}}
                                {{--                            <td>{{ $employee->termination_date }}</td>--}}
                                <td>{{ $employee->sin }}</td>
                                <td class="m-auto">
                                    <a id="download_link" onclick="pdoc_ajax({{ $employee->id }});" class="btn btn-success" href="javascript:void(0);">
                                        <div class="d-flex justify-content-center">
                                            <div id="spinner" class="spinner-border" style="display: none;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        <span id="btn_text">
                                             <i class="fas fa-file-invoice-dollar"></i>
                                            Calculate Paystub
                                        </span>

                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    @endsection

    @section('after_load')
        <script type="text/javascript">
            function payPeriod(){
                // console.log('clicked');
                var freq = document.getElementById('frequency').value;
                var pay_date = document.getElementById('payment_date').value;
                var pay_period = document.getElementById('pay_period');


                if (freq && !pay_date) {
                    console.log('add pay date')
                }else if (pay_date && !freq) {
                    console.log('add freq')
                }else if(!freq && !pay_date) {
                    console.log('add freq and pay date')
                }else { // all is added
                    console.log('ok')
                    var first_date = new Date(pay_date);
                    first_date.setDate((first_date.getDate() - 15) + 1);
                    first_date = first_date.toLocaleDateString("en-CA");
                    pay_period.value = 'pay period from: '+ first_date + ' to: ' + pay_date;


                    // console.log();
                }
                console.log(freq + ' '+ pay_date);
            }

            function pdoc_ajax(employee_id){
                var spinner = document.getElementById('spinner');
                var btn_text = document.getElementById('btn_text');

                var freq = document.getElementById('frequency').value;
                var pay_date = document.getElementById('payment_date').value;

                var first_date = new Date(pay_date);
                first_date.setDate((first_date.getDate() - 15) + 1);
                first_date = first_date.toLocaleDateString("en-CA");

                btn_text.style.display = 'none';
                spinner.style.display = 'block';
                $( document ).ready(function() {
                    $.ajax({
                        type: 'GET',
                        url: '/pdoc',
                        {{--data:'_token = <?php echo csrf_token() ?>',--}}
                        data: {
                            employee_id: employee_id,
                            frequency: freq,
                            start_date: first_date,
                            pay_date: pay_date
                        },
                        success: function (data) {
                            console.log(data)
                        }
                    });
                });
            }


        </script>

        <script type="text/javascript">
            function format(value) {
                return '<div class="pl-5">' + value + '</div>';
            }
            $(document).ready(function () {
                var table = $('#employees_table').DataTable({});

                // Add event listener for opening and closing details
                $('#employees_table').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        // Open this row
                        row.child(format(tr.data('child-value'))).show();
                        tr.addClass('shown');
                    }
                });
            });
        </script>
        <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
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
