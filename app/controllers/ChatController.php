<?php

class ChatController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //$chat = Chat::find(1);
        //$chat = Chat::where('owner', '=', Auth::user()->user_id)->first();
//        return View::make('chat')->with('chat', $chat);
	}


    public function createChat()
    {
        if(!Chat::where('owner', '=', Auth::user()->user_id)->first()) {
            $chat = new Chat(['owner' => Auth::user()->user_id, 'chat_name' => Auth::user()->userName]);
            $chat->save();
            $user = Auth::user();
            $user->chat_id = $chat->chat_id;
            $user->save();
            return View::make('chat')->with('chat', $chat);
        }
        else
        {
            $chat = Chat::where('owner', '=', Auth::user()->user_id)->first();
            $user = Auth::user();
            $user->chat_id = $chat->chat_id;
            $user->save();
            return View::make('chat')->with('chat', $chat);
        }
    }


    public function getAllPublicChats()
    {
        $chats = Chat::all();
        return View::make('allPublicChats')->with('chats', $chats);
    }

    public function getChatInfo($chat_id)
    {
        if(Request::ajax())
        {
            $chat = Chat::find($chat_id);
            return $chat->users;
        }
    }


    public function joinChat($chat_id)
    {
        $chat = Chat::find($chat_id);
        $user = Auth::user();
        $user->chat_id = $chat_id;
        $user->save();
        return View::make('chat')->with('chat', $chat);

    }

    public function exitChat($user_id)
    {
        $user = User::find($user_id);
        $user->chat_id = NULL;
        $user->save();
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function broadcast($sdp){
        User::find(9);
    }

}
