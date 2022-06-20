@extends('layouts.app')

@section('w/e')
The team named {{$team->from}} {{$team->name}} had the following players play for them: <br>
<ul>
    @foreach($players as $p)
                <li>
                     <a href="/player/{{$p->name}}">{{$p->name}}</a>
                </li>
    @endforeach
    </ul>
@yield('footer')
