@extends('layouts.app')

@section('w/e')
    <form method="post" action="/comment/{{$comment->id}}" >
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="content" value={{$comment->content}}>
        <input type="submit" value="submit">

        <p>
            <label>Choose Player
            <select id="choose_player" name="player_id">
            @foreach($players as $p)
                <option name="player_id" value="{{$p->id}}" id="pname">{{$p->name}}</option>
            @endforeach
            </select>
            </label> 
            </p>
    </form>
@yield('footer')
