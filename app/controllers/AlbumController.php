<?php

class AlbumController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
    }
    
	/**
	 * Display a listing of the albums.
	 *
	 * @return Response
	 */
	public function index()
	{
		$albums = Auth::user()->albums;

        return View::make('albums')->with('albums', $albums);

    }


	/**
	 * Show the form for creating a new album.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(Auth::check())
        {
            $user = Auth::user();
            return View::make('createNewAlbum')->with('user', $user);
        }
        else
        {
            return Redirect::to('/user');
        }
	}


	/**
	 * Store a newly created album in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
        $user = Auth::user();
        $album = new Album();
        if($album->albumValidation($data)->fails())
        {
            return View::make('createNewAlbum')->withErrors($album->albumValidation($data))->with('user', $user);
        }
        else
        {
            $album->createNewAlbum($data);
            return Redirect::to('/album');
        }
	}


	/**
	 * Display the specified album.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$album = Album::find($id);
        return View::make('showAlbum')->with('album', $album);
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
	 * Update the specified album in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $album = Album::find($id);
        $data = Input::all();
        if($album->albumValidation($data)->fails())
        {
            return View::make('showAlbum')->withErrors($album->albumValidation($data))->with('album', $album);
        }
        else
        {
            $album->updateAlbum($data);
            return View::make('showAlbum')->with('album', Album::find($id));
        }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $album = Album::find($id);
		$album->deleteAlbum();
        return Redirect::to('/album');
	}
}
