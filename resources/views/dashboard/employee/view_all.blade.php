@extends('layouts.dashboard')

@section('title')
    PDOC - View All Employees
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
        <h1 class="mt-4">View All Employees</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
            <li class="breadcrumb-item active">Employer</li>
            <li class="breadcrumb-item active">View All Employees</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <table id="example" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>name</th>
                        <th>Hire Date</th>
                        <th>Termination Date</th>
                        <th>SIN #</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr data-child-value="{{ $employee->address }}">
                            <td class="details-control"></td>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->hire_date }}</td>
                            <td>{{ $employee->termination_date }}</td>
                            <td>{{ $employee->sin }}</td>
                            <td class="m-auto">
                                <a class="btn btn-success" href="{{ route('employee_hours', ['id' => $employee->id]) }}">
                                    <i class="far fa-clock"></i>
                                </a>
                                <a class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
@section('after_load')
    <script type="text/javascript">
        function format(value) {
            return '<div class="pl-5">Address: ' + value + '</div>';
        }
        $(document).ready(function () {
            var table = $('#example').DataTable({});

            // Add event listener for opening and closing details
            $('#example').on('click', 'td.details-control', function () {
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
