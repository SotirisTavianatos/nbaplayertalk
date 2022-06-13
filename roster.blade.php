@extends('layouts.app')

@section('w/e')
The team <a href="/team/{{$team->name}}"> {{$team->from}} {{$team->name}} </a> roster for year @if ($year==Null)
{{ now()->year }} :
@else
    {{$year}} :
@endif
<ul>
    @foreach($players as $p)
                <li>
                     <a href="/player/{{$p->lastname}}">{{$p->firstname}} {{$p->lastname}}</a>
                </li>
    @endforeach
    </ul>
@yield('footer')