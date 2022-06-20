@extends('layouts.app')

@section('w/e')
comments by you:<br>
     @foreach($players as $player)
      @foreach($player->commentsfor as $c)
             {{$c->content}} <br>
             was written for <a href="/player/{{$player->name}}">{{$player->name}}</a> {{$c->likes}} likes {{$c->updated_at}} <br>
             <button type="button" onclick="window.location='{{ url("/comment/{$c->id}/edit") }}'">Edit</button>
             <form method="post" action="/comment/{{$c->id}}">
                @csrf
                <input type="hidden" name="_method" value=DELETE>
                <input type="submit" value="Delete" >
             </form> 
       @endforeach
    @endforeach
@yield('footer')
