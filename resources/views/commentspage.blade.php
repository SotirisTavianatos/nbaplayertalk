@extends('layouts.app')
@section('w/e')
comments by our users:<br><br>
@foreach ($comments as $c)
   {{$c->content}} 
   @if($c->likedby()->where('user_id',auth()->user()->id)->exists())
   <form method="post" action="/dislike/{{$c->id}}">
      @csrf
      <button type="submit" >Liked</button>
   </form>
   @else
   <form method="post" action="/like/{{$c->id}}">
      @csrf 
      <button type="submit" >Like</button>
   </form> 
   @endif
   was written for <a href="/player/{{$c->player->lastname}}">{{$c->player->lastname}}</a> {{$c->likes}} likes {{$c->updated_at}} <br>
    <br><br><br>
@endforeach
@yield('footer')
