@extends('layouts.app')

@section('content')
   @include('admin.users._nav')
    <h3 align="center">  Это админка  {{ Auth::user()->name }}   !!</h3>
<div>


    <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>E-mail</th>

        </tr>
        </thead>
        <tbody>

        @foreach($user as $users)
            <tr>
                <td>{{$users->id}}</td>
                <td><a href="{{route('users.show',$users)}}"> {{$users->name}}</a></td>
                <td>{{$users->email}}</td>


            </tr>

    @endforeach
        </tfoot>
    </table>
    {{$user->links()}}
</div>
@endsection