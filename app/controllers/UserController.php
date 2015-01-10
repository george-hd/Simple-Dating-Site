<?php

class UserController extends \BaseController {

	/**
	 * Display the login form.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('loginform');
	}

    /**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('userRegister');
	}

    /**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $inputData = Input::all();
		$user = new User();

        if($user->registerUserValidation($inputData)->fails())
        {
            return View::make('userRegister')->withErrors($user->registerUserValidation($inputData));
        }
        else
        {
            $user->saveUserToDb($inputData);
            Auth::attempt(array('userName' => $inputData['userName'], 'password' => $inputData['password']), true);
            return Redirect::to('/')->with(array('user', $user));
        }
	}

    /**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        if(Auth::check())
        {
            if(Request::ajax())
            {
                return User::find($id);
            }
            else
            {
                $user = User::find($id);
                return View::make('showUser')->with('user', $user);
            }

        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(Auth::check())
        {
            $userId = Auth::user()->user_id;
            $user = User::find($userId);
            return View::make('editProfile')->with(array('user' => $user));
        }
        else
        {
            return View::make('user');
        }
	}

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $user_id
	 * @return Response
	 */

    public function update($user_id)
    {
        if(Auth::check())
        {
            $data = Input::all();
            $user = User::find($user_id);
            if (isset($data['userName']) || isset($data['email']) || isset($data['firstName']) || isset($data['lastName']))
            {
                if ($user->userDataValidation($data)->fails())
                {
                    return View::make('editProfile')->withErrors($user->userDataValidation($data))->with('user', $user);
                }
                else
                {
                    $user->updateUserData($data);
                    $user = User::find($user_id);
                    return View::make('editProfile')->with('user', $user);
                }
            }
            elseif (isset($data['avatar']))
            {
                if ($user->avatarValidation($data)->fails())
                {
                    return View::make('editProfile')->withErrors($user->avatarValidation($data))->with('user', $user);
                }
                else
                {
                    $user->updateUserAvatar($data);
                    return View::make('editProfile')->with('user', $user);
                }
            }
            elseif (isset($data['password']) || isset($data['confirm']))
            {
                if ($user->passwordValidation($data)->fails())
                {
                    return View::make('editProfile')->withErrors($user->passwordValidationData($data))->with('user', $user);
                }
                else
                {
                    if(Hash::check($data['oldPassword'], Auth::user()->password))
                    {
                        $user->changePassword($data);
                        return View::make('editProfile')->with('user', $user);
                    }
                    else
                    {
                        return View::make('editProfile')->with('flash', 'invalid password')->with('user', $user);
                    }

                }
            }
            else
            {
                return View::make('editProfile')->with('user', $user);
            }
        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
     * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Auth::user();
        $user->delete();
        return Redirect::to('/');
	}

    /**
     * @return mixed
     */
    public function login()
    {
        if(Auth::attempt(array('userName' => trim(htmlentities(Input::get('userName'))), 'password' => trim(htmlentities(Input::get('password')))), true))
        {
            return Redirect::to('/');
        }
        else
        {
            return View::make('loginform')->with(array('error' => 'Wrong user name or password'));
        }
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        if(Auth::check()){
            $user = Auth::user()->user_id;
            Auth::logout($user);
            return Redirect::to('/user');
        }
        else{
            return Redirect::to('/user');
        }
    }

    /**
     * @return mixed
     */
    public function showAllUsers()
    {
        if(Auth::check())
        {
            $users = User::all();

            return View::make('showAllUsers')->with('users', $users);
        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function inviteFriend($id)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user->askFriendship($id);
            return Redirect::back();
        }
        else
        {
            return Redirect::to('user');
        }
    }

    public function deleteFriend($friend)
    {
        Auth::user()->deleteFriend($friend);
        $userName = User::find($friend)->userName;
        $data = array('message_body' => $userName.' deleted you from his/her friend list.');

        Message::send($friend, $data);
        return Redirect::to('showFriends');
    }

    public function rejectFriendship($sender_id)
    {
        if(Auth::check())
        {
            Auth::user()->rejectFriendship($sender_id);
            return Redirect::to('showFriends');
        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
     * @return mixed
     */
    public function friendRequests()
    {
        if(Auth::check())
        {
            return View::make('showFriendRequests');
        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
     * @param $sender_id
     * @return mixed
     */
    public function acceptFriendship($sender_id)
    {
        if(Auth::check())
        {
            Auth::user()->acceptFriendship($sender_id);
            $senderName = User::find($sender_id)->userName;
            $data = array('message_body' => 'You are already friends with '.$senderName);
            Message::send($sender_id, $data);
            return Redirect::to('showFriends');
        }
        else
        {
            return Redirect::to('user');
        }

    }

    /**
     * @return mixed
     */
    public function showAllFriends()
    {
        if(Auth::check())
        {
            return View::make('showFriends')->with('friends', User::getFriends());
        }
        else
        {
            return Redirect::to('user');
        }
    }

    /**
     * ajax request from the browser if user is still online
     * return the current time just for testing
     */
    public function isUserOnline()
    {
        $user = Auth::user();

        $user->updateLastPing();

        User::updateWhoIsOnline();

        return Carbon::now('Europe/Sofia');
    }
}
