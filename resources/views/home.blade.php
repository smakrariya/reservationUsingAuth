@extends('layouts.app')

@section('content')

    <meta http-equiv="refresh" content="1;url=/reservation">
    <script type="text/javascript">
        window.location.href="/reservation";
    </script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
