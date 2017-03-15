@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Auth::guest())
                <div class="panel panel-default">
                    <h1>Hello, please login</h1>
                </div>
            @else
                <div class="panel panel-default">
                    <h1>Hello,</h1>
                    <h2>Home page</h2>
                </div>
            @endif

            @if($status = Session::get('status'))
                <div class="alert alert-info">
                    {{$status}}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
