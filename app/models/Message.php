<?php

class Message extends Eloquent {

    protected $table = 'messages';
    protected $primaryKey = 'message_id';
    protected $fillable = array('message_body', 'is_readed', 'sender', 'receiver', 'created_at', 'updated_at');

    public static function messageValidation($data)
    {
        $rules = array(
            'message_body' => 'required | max:500'
        );

        $messages = array(
            'message_body.required' => 'message can not be empty.',
            'message_body.max' => 'message can\'t be more then 500 characters.'
        );

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    public static function getAllMessagesOfCurrentUser()
    {
        $user = Auth::user();
        $messages = Message::where('receiver', '=', $user->user_id)->orderBy('created_at', 'DESC')->get();
        return $messages;
    }

    public function changeMessageReadStatus()
    {
        Message::updateOrCreate(
          [
              'is_readed' => $this->is_readed,
          ],
          ['is_readed' => '1']
        );
    }

    public static function countOfUnreadMessages()
    {
        return Message::where('receiver', '=', Auth::user()->user_id)
            ->where('is_readed', '=', 0)->count();
    }

    public static function send($id, $data)
    {
        Message::create(
            [
                'message_body' => htmlentities(trim($data['message_body'])),
                'receiver' => User::find($id)->user_id,
                'sender' => Auth::user()->user_id
            ]
        );
    }
} 