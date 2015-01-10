<?php

class PictureController extends \BaseController {

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
		//
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
        $data = Input::all();
        $pic = new Picture();
        $album = Album::find($data['album_id']);
        if(isset($data['picture']))
        {
            if($pic->pictureValidate($data)->fails())
            {
                return View::make('showAlbum')->withErrors($pic->pictureValidate($data))->with('album', $album);
            }
            else
            {
                Input::file('picture')->move(public_path().'/images', $_FILES['picture']['name']);

                $pic->album_id = trim(htmlentities($data['album_id']));
                $pic->picture_link = '/images/' . basename($_FILES["picture"]["name"]);
                $pic->save();

                return View::make('showAlbum')->with('album', $album);
            }
        }
        else
        {
            return View::make('showAlbum')->with('album', $album);
        }
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


}
