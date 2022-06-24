<?php

namespace Tests\Feature;
namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_kati()
    {
        $request = Request::create('/player/{playername}', 'POST',[
            'firstname'=> 'ja',
            'lastname'=>'morant',
            'age'=>'22',
            'position'=>'pg'
        ]);
        $request2 = Request::create('/player/{teamname}', 'POST',[
            'name'=> 'grizzlies',
            'from'=>'memphis',
        ]);
        $request3 = Request::create('/player/{player_team}', 'POST',[
            'team_id'=> 'grizzlies',
            'player_id'=>'memphis',
            'from'=>'2019',
            'until'=>NULL
        ]);


        $controller = new CommentController();
        $response=$controller->playerinfo($request);
    }
}
