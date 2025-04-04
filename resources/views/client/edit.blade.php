@extends('master')

@section('content')

<div class="row">
 <div class="col-md-12">
  <br />
  <h3>Edit Record</h3>
  <br />
  @if(count($errors) > 0)

  <div class="alert alert-danger">
         <ul>
         @foreach($errors->all() as $error)
          <li>{{$error}}</li>
         @endforeach
         </ul>
  @endif 
  <form method="post" action="{{route('client.update',['id'=>  $id])}}">
   {{csrf_field()}}
   <input type="hidden" name="_method" value="PATCH" />
   <div class="form-group">
    <input type="text" name="first_name" class="form-control" value="{{$client->first_name}}" placeholder="Enter First Name" />
   </div>
   <div class="form-group">
    <input type="text" name="last_name" class="form-control" value="{{$client->last_name}}" placeholder="Enter Last Name" />
   </div>
   <div class="form-group">
        <label for="type">Client Type</label>
        <select name="type" class="form-control">
            <option value="Residentiel" {{ $client->type == 'Residentiel' ? 'selected' : '' }}>Residentiel</option>
            <option value="Affaire" {{ $client->type == 'Affaire' ? 'selected' : '' }}>Affaire</option>
        </select>
    </div>
   <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Edit" />
   </div>
  </form>
 </div>
</div>

@endsection
