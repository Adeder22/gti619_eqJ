@extends('master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <br />
        <h3 align="center">{{ $title }}</h3>
        <table class="table table-bordered table-striped">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Type</th>
            </tr>
            @foreach($clients as $row)
            <tr>
                <td>{{$row['first_name']}}</td>
                <td>{{$row['last_name']}}</td>
                <td>{{$row['type']}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection