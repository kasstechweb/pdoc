@extends('layouts.dashboard')

@section('title')
    PDOC - Home
@endsection

@section('content')

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
