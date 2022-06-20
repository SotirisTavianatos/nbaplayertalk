@extends('layouts.app')

@section('w/e')
comments by you:<br>
     @foreach($comments as $c)
             {{$c->content}} <br>
             was written for <a href="/player/{{$players[$c->player_id-1]}}">{{$players[$c->player_id-1]}}</a> {{$c->likes}} likes {{$c->updated_at}} <br>
             <button type="button" onclick="window.location='{{ url("/comment/{$c->id}/edit") }}'">Edit</button>
             <form method="post" action="/comment/{{$c->id}}">
                @csrf
                <input type="hidden" name="_method" value=DELETE>
                <input type="submit" value="Delete" >
             </form> 
    @endforeach
@yield('footer')
