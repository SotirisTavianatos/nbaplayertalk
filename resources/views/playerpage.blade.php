@extends('layouts.app')

@section('w/e')
{{$player->firstname}} {{$player->lastname}} is {{$player->age}} years old. <br>
@if ($currentteam==null)
    He has retired <br>
@else
    He currently plays as a {{$player->position}} for the {{$currentteam}} <br>
@endif
He averages {{$stat->points}} points per game <br> 
These are the teams he has played for in his career:
<ul>
@foreach($player->teams as $p)
            <li>
               <a href="/team/{{$p->name}}"> {{$p->from}}    {{$p->name}}  </a>
            </li>
@endforeach
</ul>
<br>
Comments about {{$player->lastname}} :
<ul>
    @foreach($comments as $c)
                <li>
                    {{$c->content}}    <br>
                    {{$c->likes}} likes                  {{$c->updated_at}}
                </li>
    @endforeach
    </ul>
@yield('footer')
