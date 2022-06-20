@extends('layouts.app')

@section('w/e')
comments by our users:<br><br>

@for ($i = 0; $i < count($comment); $i++)
            {{$comment[$i]->content}} 
            @if ($likes[$i]==0)
               <form method="post" action="/like/{{$comment[$i]->id}}">
                   @csrf 
                   <button type="submit" >Like</button>
               </form> 
            @else
               <form method="post" action="/dislike/{{$comment[$i]->id}}">
                  @csrf
                  <button type="submit" >Liked</button>
               </form> 
            @endif
             was written for <a href="/player/{{$players[$i]}}">{{$players[$i]}}</a> {{$comment[$i]->likes}} likes {{$comment[$i]->updated_at}} <br>
             <br><br><br>
@endfor
@yield('footer')
