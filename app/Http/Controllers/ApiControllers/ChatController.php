<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetConversionRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getAllConversations(Request $request){
        $user_id = $this->bbToken($request->bearerToken());
        $message = Message::with('user')->where('sender_id',$user_id)->groupBy('conversation_id')->orderBy('created_at','ASC')->get();
        return response()->json(['message'=>'Conversations Fetched','conversations'=>$message],200);
    }

    public function getConversation(GetConversionRequest $request){
        $messages = Message::where('conversation_id',$request->conversation_id)->orderBy('created_at','ASC')->get();
        return response()->json(['message'=>'Conversations Fetched','conversations'=>$messages],200);
    }

    // public function deleteConversation(GetConversionRequest $request){
    //     $user_id = $this->bbToken($request->bearerToken());
    //     // $messages = Message::where('conversation_id',$request->conversation_id)->orderBy('created_at','ASC')->get();
    //     $message = Message::where(['conversation_id',$request->conversation_id],['sender_id',$user_id])->update([
    //             'status'=> 'disable',
    //     ]);
    //     return response()->json(['message'=>'Conversations Fetched','conversations'=>$message],200);
    // }

    public function bbToken($token){
        $user = User::where('accesstoken',$token)->first();
        if($user){
            return $user->id;
        }else{
            return response()->json(['message'=>'Invalid Token'], 422);
        }
    }
}