<?php

class Picture extends Eloquent {

    protected $table = 'pictures';
    protected $primaryKey = 'picture_id';
    protected $fillable = array('picture_id', 'picture_link', 'album_id', 'picture_description', 'created_at', 'updated_at');

    public function pictureValidate($data)
    {
        $rules = array(
            'picture' => 'mimes:jpg,jpeg,bmp,png, | max:5000'
        );

        $messages = array(
            'picture.mimes' => 'the file must be jpg, jpeg, bmp or png',
            'picture.max' => 'the file is too large. Max allowed size is 5 MB.'
        );

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    public function users()
    {
        return $this->belongsTo('Album');
    }
} 