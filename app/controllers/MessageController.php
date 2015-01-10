<?php

class MessageController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $messages = Message::getAllMessagesOfCurrentUser();

        $messagesData = array();
        foreach ($messages as $msg)
        {
            $messagesData[] = new messageViewModel($msg);
        }


        return View::make('showMessages')->with('messagesData', $messagesData);
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
        $message = Message::find($id);
        $message->changeMessageReadStatus();
        $messageViewModel = new messageViewModel($message);
        return View::make('showMessage')->with('messageViewModel', $messageViewModel);
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
		//Message::find($id)->delete();
        Message::destroy($id);
        return Redirect::to('message');
	}

    public function sendMessage($id)
    {
        $receiver = User::find($id);
        $data = Input::all();
        if(Message::messageValidation($data)->fails())
        {
            return View::make('showUser')->withErrors(Message::messageValidation($data))->with('user', $receiver);
        }
        else
        {
            Message::send($id, $data);
            return View::make('showUser')->with('user', $receiver)->with('flash', 'The message was successfully sent.');
        }
    }
}
