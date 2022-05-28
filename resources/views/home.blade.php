@extends('layouts.app')

@section('w/e')

<a href="/allcomments"> read all the comments by our users!  </a> <br>
<a href="/comment/create">  write a new comment </a> <br>
<a href="/mycomments">  check your comments </a> <br>
<a href="{{ route('signout') }}">Logout</a>

@yield('footer')
