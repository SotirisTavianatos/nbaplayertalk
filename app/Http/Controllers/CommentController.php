<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Team;
use App\Models\Stat;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "comment saved!";
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
        $people=Player::all();
        return view('createcomment',compact('people'));
        }
        else  
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment= new Comment;
        $comment->content=$request->content;
        $comment->player_id=$request->choose_player;
        $comment->user_id=auth()->user()->id;
        $comment->save();
        return redirect('/comment');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment=DB::table('comments')->where('id',$id)->first();
        $players=Player::all();
        return view('mycommenteditpage',compact('comment','players'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment=Comment::find($id);
        $comment->content=$request->content;
        $comment->player_id=$request->player_id;
        $comment->timestamps=true;
        $comment->update();
        return redirect('/comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment=Comment::find($id);
        $comment->delete();
        return redirect('/allcomments');
    }

    public function playerinfo($playername){
        $idpaixth=DB::table('players')->where('name', $playername)->value('id');
        $stat=Stat::find($idpaixth);
        $player=Player::find($idpaixth);
        $currentteam=$player->currentteam($idpaixth);
        $comments=$player->commentsfor;
        return view('playerpage',compact('stat','player','currentteam','comments'));
     }

     public function teaminfo($teamname){
        $team=DB::table('teams')->where('name', $teamname)->first();
        $players=Team::find($team->id)->played;
        return view('teampage',compact('team','players'));
     }

     public function allcomments(){
         $comments=DB::table('comments')->orderBy('likes','desc')->get();
         $players=[];
         $likes=[];
         $comment=[];
         foreach ($comments as $c){
         array_push($players,Player::find($c->player_id)->name);
         array_push($comment,$c);
         }
         foreach ($comments as $c){
             $com=Comment::find($c->id);
             $like=$com->likedby()->where('user_id',auth()->user()->id)->exists();
             if($like==1)
             array_push($likes,1);
             else
             array_push($likes,0);   
         }
        return view('commentspage',compact('comment','players','likes'));
     }

     public function mycomments(){
        if (Auth::check()) {
            $comments=DB::table('comments')->where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
            $players=[];
            foreach ($comments as $c)
            array_push($players,Player::find($c->player_id)->name);
            return view('mycommentspage',compact('comments','players'));
            }
        else  
            return redirect('/login');
       
    }

    public function home()
    {
        if(Auth::check()){
            return view('home');
        }
   
        return redirect("login")->withSuccess('are not allowed to access');
    }

    public function like($cid){
        $comment=Comment::find($cid);
        $comment->likes=$comment->likes+1;
        $comment->timestamps=false;
        $comment->update();
        $notification = new Notification();
        $notification->comments_id=$cid;
        $notification->save();
        $comment->likedby()->attach(auth()->user()->id);
        return redirect('/allcomments');
    }

    public function dislike($cid){
        $comment=Comment::find($cid);
        $comment->likes=$comment->likes-1;
        $comment->timestamps=false;
        $comment->update();
       // $notification = new Notification();
      //  $notification->comments_id=$cid;
      //  $notification->save();
        $comment->likedby()->detach(auth()->user()->id);
        return redirect('/allcomments');
    }
}
