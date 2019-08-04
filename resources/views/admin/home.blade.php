@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" href="{{route('admin.home')}}">Dashboard Приборная панель</a>

        </li>
        <li class="nav-item"><a class="nav-link " href="{{route('users.index')}}">User Приборная панель</a>

        </li>

    </ul>

                      <h3 align="center">  Это админка  {{ Auth::user()->name }}   !!</h3>

@endsection