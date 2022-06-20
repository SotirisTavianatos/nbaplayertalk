@extends('layouts.app')

@section('w/e')
The team named {{$team->from}} {{$team->name}} had the following players play for them: <br>
<a href="/currentroster/{{$team->name}}">current roster</a>
<ul>
    @foreach($players as $p)
                <li>
                     <a href="/player/{{$p->lastname}}">{{$p->firstname}} {{$p->lastname}}</a>
                </li>
    @endforeach
    </ul>
@yield('footer')
