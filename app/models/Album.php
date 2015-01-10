<?php

class Album extends Eloquent {

    protected $table = 'albums';
    protected $primaryKey = 'album_id';
    public $timestamps = false;
    protected $fillable = array('album_name', 'user_id', 'is_public');

    public function albumValidation($data)
    {
        $rules = array(
            'album_name' => 'required | alpha_dash | min: 4 | max: 50',
            'is_public' => 'boolean'
        );

        $messages = array(
            'required' => ':attribute is required.',
            'alpha_dash' => 'only dashes, characters and numbers are allowed.',
            'min' => ':attribute must be between 4 and 50 characters.',
            'max' => ':attribute must be between 4 and 50 characters.',
            'boolean' => 'the field must be of boolean type'
        );

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
    }

    public function createNewAlbum($data)
    {
        Album::create(
            [
                'album_name' => $data['album_name'],
                'user_id' => Auth::user()->user_id
            ]
        );
    }

    public function updateAlbum($data)
    {
        Album::updateOrCreate(
            [
                'album_name' => $this->album_name,
                'is_public' => $this->is_public
            ],
            $data
        );
    }

    public function deleteAlbum()
    {
        if(count($this->pictures) > 0)
        {
            $pictures = array();
            foreach ($this->pictures as $pic)
            {
                $pictures[] = $pic->picture_id;
            }
            Picture::destroy($pictures);
            $this->delete();
        }
        else
        {
            Album::destroy($this->album_id);
        }
    }

    public function pictures()
    {
        return $this->hasMany('Picture');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
} 