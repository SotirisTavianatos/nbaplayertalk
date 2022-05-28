@extends('layouts.app')

@section('w/e')
    <form method="post" action="/comment" >
        @csrf
        <input type="text" name="content" placeholder="enter comment">
        <input type="submit" value="submit">

        <p>
            <label>Choose Player
            <select id="choose_player" name="choose player">
            @foreach($people as $p)
                <option name="player_id" value="{{$p->id}}" id="pname">{{$p->name}}</option>
            @endforeach
            </select>
            </label> 
            </p>
    </form>
@yield('footer')
