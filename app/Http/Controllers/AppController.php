<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Chat;
use Auth;

class AppController extends Controller
{
     
    public function index()
    {
        // Get all users except current logged in
        $users = User::where('id', '!=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
        return view('app.inicio', compact('users'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('entrar');
    }

    public function usersChat($userName)
    {

        $receptorUser = User::where('id', '=', $userName)->first();
        //
        if($receptorUser == null) {
            return view('app.nousernamefinded', compact('userName'));
        }else {
            $users = User::where('id', '!=', Auth::user()->id)->take(10)->get();
            
             $group =  DB::table('group_user')->leftjoin('Group','group_user.group_id','=','Group.id')->  select('Group.name','group_user.*')->where('group_user.user_id', '=', Auth::user()->id)->get();
         
            $chat = $this->hasChatWith($receptorUser->id); 
            return view('app.chat', compact('receptorUser', 'chat', 'users'));
        }
    }
  public function groupChat($userName)
    {


         $chat2 = Chat::where('group_id', 1)->orderBy('id','asc')->first();
         if(@$chat2){
            $receptorUser = User::where('id', $chat2->user_id1)->first(); 
        }else{
           $receptorUser = ""; 
        }
         
         
        $groupname = DB::table('Group')->where('id', '=', $userName)->first();
         
        if($receptorUser == null) {
           $users = User::where('id', '!=', Auth::user()->id)->take(10)->get();
             $group =  DB::table('group_user')->leftjoin('Group','group_user.group_id','=','Group.id')->  select('Group.name','group_user.*')->where('group_user.user_id', '=', Auth::user()->id)->get();
         
            $chat = $this->hasGChatWith($groupname->id); 
            return view('app.chat', compact('receptorUser', 'chat', 'users','groupname'));
        }else {
            $users = User::where('id', '!=', Auth::user()->id)->take(10)->get();
             $group =  DB::table('group_user')->leftjoin('Group','group_user.group_id','=','Group.id')->  select('Group.name','group_user.*')->where('group_user.user_id', '=', Auth::user()->id)->get();
         
            $chat = $this->hasGChatWith($groupname->id); 
            return view('app.chat', compact('receptorUser', 'chat', 'users','groupname'));
        }
    }
    public function hasGChatWith($groupid)
    {
      echo $groupid;

        $chat = Chat::where('group_id', $groupid)->where('user_id2', 0)->orderBy('id','desc')->first();
     
        if(isset($chat)){
             $chat2 = Chat::where('group_id', 1)->orderBy('id','asc')->first();
               
            $this->createGroupChat(Auth::user()->id, $groupid, $chat2->user_id1);
            return $chat;
        }else{
            $userId2 = 0;
            return $this->createGroupChat(Auth::user()->id, $groupid, $userId2);
        }
    }
    public function hasChatWith($userId)
    {
      


        $chat = Chat::where('user_id1', Auth::user()->id)
            ->where('user_id2', $userId)
            ->orWhere('user_id1', $userId)
            ->where('user_id2', Auth::user()->id)
            ->get();
        if(!$chat->isEmpty()){
            return $chat->first();
        }else{
            return $this->createChat(Auth::user()->id, $userId);;
        }
    }
 public function createGroupChat($userId1, $groupid,$userId2)
    {

        $gchat = Chat::create([
            'user_id1' => $userId1,
            'user_id2' => $userId2,
            'group_id' => $groupid,
            'type' => "group"
        ]);
        
        return $gchat;
    }
    public function createChat($userId1, $userId2)
    {
        $chat = Chat::create([
            'user_id1' => $userId1,
            'user_id2' => $userId2
        ]);
        return $chat;
    }
}
