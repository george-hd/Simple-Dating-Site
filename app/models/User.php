<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = array('userName', 'firstName', 'lastName', 'email', 'password', 'avatar', 'is_online');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    /**
     * Validate the user input from the register form.
     * @param $data
     * @return mixed
     */
    public function registerUserValidation($data)
    {
        $validationRules = array(
            'userName' => 'min:4 | max:50 | required | unique:users',
            'email' => 'required | email | unique:users',
            'password' => 'required | min:6 | max:20 | same:confirm',
            'confirm' => 'required | same:password'
        );

        $messages = array(
            'userName.required' => 'the :attribute is required.',
            'userName.min' => 'the :attribute must be between 4 and 50 characters.',
            'userName.max' => 'the :attribute must be between 4 and 50 characters.',
            'userName.unique' => 'the :attribute is already taken.',
            'email.required' => 'the :attribute is required.',
            'email.email' => 'the :attribute is not valid.',
            'email.unique' => 'the :attribute is already taken.',
            'password.required' => 'the :attribute is required.',
            'password.min' => 'the :attribute must between 6 and 20 characters.',
            'password.max' => 'the :attribute must between 6 and 20 characters.',
            'password.same' => 'the fields :attribute and confirm password must be the same.',
            'confirm.required' => 'the :attribute is required.',
            'confirm.same' => 'the fields password and confirm password must be the same.'
        );

        $validator = Validator::make($data, $validationRules, $messages);
        return $validator;
    }

    /**
     * Validates user data(userName, firstName, lastName and email) at the update method
     * @param $data
     * @param $user_id
     * @return mixed
     */
    public function userDataValidation($data)
    {
        $rules = array(
            'userName' => 'required | min:4 | max:50 | unique:users,userName,'.$this->user_id.',user_id',
            'email' => 'required | email | unique:users,email,'.$this->user_id.',user_id',
            'firstName' => 'min:4 | max:50',
            'lastName' => 'min:4 | max:50'
        );

        $messages = array(
            'userName.required' => 'the :attribute is required.',
            'userName.min' => 'the :attribute must be between 4 and 50 characters.',
            'userName.max' => 'the :attribute must be between 4 and 50 characters.',
            'userName.unique' => 'the :attribute is already taken.',
            'email.required' => 'the :attribute is required.',
            'email.email' => 'the :attribute is not valid.',
            'email.unique' => 'the :attribute is already taken.',
            'firstName.min' => 'the :attribute must be between 4 and 50 characters.',
            'firstName.max' => 'the :attribute must be between 4 and 50 characters.',
            'lastName.max' => 'the :attribute must be between 4 and 50 characters.',
            'lastName.min' => 'the :attribute must be between 4 and 50 characters.',
        );

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * Validates the user avatar
     * @param $data
     * @return mixed
     */
    public function avatarValidation($data)
    {
        $rules = array(
            'avatar' => 'mimes:jpg,jpeg,bmp,png, | max:5000'
        );

        $messages = array(
            'avatar.mimes' => 'the :attribute format must be jpeg, jpg, bmp or png',
            'avatar.max' => 'The file is too large.Max allowed size 5 MB'
        );
        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * Validates the user password and confirm password
     * @param $data
     * @return mixed
     */
    public function passwordValidation($data)
    {
        $rules = array(
            'password' => 'required | min:6 | max:20 | same:confirm',
            'confirm' => 'required | same:password'
        );

        $messages = array(
            'password.required' => 'the :attribute is required.',
            'password.min' => 'the :attribute must between 6 and 20 characters.',
            'password.max' => 'the :attribute must between 6 and 20 characters.',
            'password.same' => 'the fields :attribute and confirm password must be the same.',
            'confirm.required' => 'the :attribute is required.',
            'confirm.same' => 'the fields password and confirm password must be the same.'
        );
        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    /**
     * @param array $data
     */
    public function updateUserData(Array $data)
    {
        User::updateOrCreate(
            [
                'userName' => $this->userName,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email
            ],
            $data
        );
    }

    /**
     * @param array $data
     */
    public function updateUserAvatar($data)
    {
        $data['avatar']->move(public_path()."/images/", $_FILES['avatar']['name']);
        $this->avatar = "/dir/project/public/images/".basename($_FILES['avatar']['name']);
        $this->save();
    }

    //sets is_online to true (1)
    public function updateUserOnline()
    {
        $this->is_online = 1;
        $this->save();
    }

    //sets is_online to false (0)
    public function updateUserOffline()
    {
        $this->is_online = 0;
        $this->save();
    }

    /**
     * @param array $data
     */
    public function changePassword(Array $data)
    {
        User::updateOrCreate(
            [
                'password' => $this->password,
            ],
            array(Hash::make(trim($data['password'])))
        );
    }

    /**
     * @param $data
     */
    public function saveUserToDb($data)
    {
        User::create(
            [
                'userName' => htmlentities(trim($data['userName'])),
                'email' => htmlentities(trim($data['email'])),
                'password' => Hash::make(htmlentities(trim($data['password']))),
                'avatar' => "https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQFeJYxm0VsMkxYNYSaWQpGG4GGSwmHoB2Hz0AwIKCEwv3CjyWV"
            ]
        );
    }

    /**
     * @param $id
     */
    public function askFriendship($id)
    {
        $friend = User::find($id);
        $friend->friends()->sync(array($this->user_id), false);
    }

    /**
     * @return int
     */
    public static function getCountFriendRequests()
    {
        if (Auth::check())
        {
            $friends = Auth::user()->friends;
        $count = 0;
        foreach ($friends as $friend) {
            if ($friend->pivot->user_id == Auth::user()->user_id && $friend->pivot->is_friend == 0) {
                $count++;
            }
        }
        return $count;
        }
        else
        {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function getAllFriendRequests()
    {
        $friends = Auth::user()->friends;
        $requests = array();
        foreach ($friends as $friend)
        {
            if($friend->pivot->user_id == Auth::user()->user_id && $friend->pivot->is_friend == 0)
            {
                $requests[] = $friend;
            }
        }
        return $requests;
    }

    /**
     * @param $requester_id
     */
    public function acceptFriendship($requester_id)
    {
        //$this->friends()->sync(array($requester_id), false);
        $friend = User::find($requester_id);
        $friend->friends()->sync(array($this->user_id), false);
        $friend->friends()->updateExistingPivot($this->user_id, ['is_friend' => 1]);
        $this->friends()->updateExistingPivot($friend->user_id, ['is_friend' => 1]);
    }

    public function rejectFriendship($requester_id)
    {
        $friends = Auth::user()->friends;
        foreach ($friends as $friend)
        {
            $friend->pivot->whereRaw('friend_id = ? and user_id = ?', array($requester_id, Auth::user()->user_id))->delete();
        }
    }

    public function deleteFriend($friend_id)
    {
        $friends = $this->friends;
        foreach($friends as $friend)
        {
            $friend->pivot->whereRaw('friend_id = ? and user_id = ?', array($friend_id, Auth::user()->user_id))->delete();
            $friend->pivot->whereRaw('friend_id = ? and user_id = ?', array(Auth::user()->user_id, $friend_id))->delete();
        }
    }

    /**
     * @return mixed
     */
    public function albums()
    {
        return $this->hasMany('Album');
    }

    /**
     * @return mixed
     */
    public function friends()
    {
        return $this->belongsToMany('User', 'users_friends', 'user_id', 'friend_id')->withPivot('is_friend');
    }

    public function chat()
    {
        return $this->belongsTo('Chat');
    }

    /**
     * get all friends of the current user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getFriends()
    {
        $friends = Auth::user()->friends;
        foreach ($friends as $friend)
        {
            if($friend->pivot->is_friend == 1)
            {
                $fr[] = $friend;
            }
        }
        if(isset($fr))
        {
            return new \Illuminate\Database\Eloquent\Collection($fr);
        }
        else
        {
            return new \Illuminate\Database\Eloquent\Collection();
        }
    }


    // called by ajax if user is still online and save the time of the request

    public function updateLastPing()
    {
        $this->last_ping = Carbon::now();
        $this->save();
    }

    /**
     * checks difference between the last ping time and current time
     * if it is more then 2 minutes updates the "is_online" column to false (0).
     */
    public static function updateWhoIsOnline()
    {
        $users = User::all();
        foreach($users as $u)
        {
            $lastPing = $u->last_ping;
            $twoMinAgo = Carbon::now()->subMinutes(2);
            $result = Carbon::createFromFormat('Y-m-d H:i:s', $lastPing);

            if($twoMinAgo->lt($result))
            {
                $u->is_online = 1;
                $u->save();
            }
            else
            {
                $u->is_online = 0;
                $u->save();
            }
        }
    }
}
