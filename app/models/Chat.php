<?php

class Chat extends Eloquent {

    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;
    protected $fillable = array('chat_id', 'chat_name', 'owner');

    public function users()
    {
        return $this->hasMany('User');
    }
} 