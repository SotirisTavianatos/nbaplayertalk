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

    public function __construct()
{
    $this->middleware('throttle:comment')->only('create');
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
        $idpaixth=DB::table('players')->where('lastname', $playername)->value('id');
        $stat=Stat::find($idpaixth);
        $player=Player::find($idpaixth);
        $currentteam=$player->currentteam();
        $comments=$player->comments;
        return view('playerpage',compact('stat','player','currentteam','comments'));
     }

     public function teaminfo($teamname){
        $team=DB::table('teams')->where('name', $teamname)->first();
        $players=Team::find($team->id)->players;
        return view('teampage',compact('team','players'));
     }

     public function currentroster($teamname){
        $team=Team::where('name', $teamname)->first();
        $playersid=DB::table('player_team')->where('team_id',$team->id)->get();
        $players=collect();
        foreach ($playersid as $p) {
            if(DB::table('player_team')->where('team_id',$team->id)->where('player_id',$p->player_id)->whereNull('until')->exists()){
                $players->push(Player::find($p->player_id));
            }
        }
        $year=NUll;
        return view('roster',compact('team','players','year'));
        
     }

     public function allcomments(){
        if (Auth::check()) 
        {
        $comments=Comment::with('player','likedby')->orderBy('likes','desc')->get();
        return view('commentspage',compact('comments'));
        }
        else  
            return redirect('/login');
     }

     public function mycomments(){
        if (Auth::check()) 
        {
            $players=Player::with(['comments' => function ($query) {
                $query->where('user_id',auth()->user()->id);
            }])->get();
            return view('mycommentspage',compact('players'));
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

    public function yearroster($year,$teamname){
        $team=Team::where('name', $teamname)->first();
        $playersid=DB::table('player_team')->where('team_id',$team->id)->get();
        $players=collect();
        foreach ($playersid as $p) {
            if(DB::table('player_team')->where('team_id',$team->id)->where('player_id',$p->player_id)->where('from','<',$year)->whereNull('until')->exists()){
                $players->push(Player::find($p->player_id));
            }
            elseif(DB::table('player_team')->where('team_id',$team->id)->where('player_id',$p->player_id)->where('from','<',$year)->where('until','>',$year)->exists()){
                $players->push(Player::find($p->player_id));
            }
        }
        return view('roster',compact('team','players','year'));
     }
}
