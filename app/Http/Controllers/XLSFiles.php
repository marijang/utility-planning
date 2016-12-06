<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use Validator;
use Redirect;
use Request;
use Session;

class XLSFiles extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$entries = Fileentry::all();
 
		return view('fileentries.index', compact('entries'));
	}
	
    public function upload() {
  		// getting all of the post data
  		$file = array('file' => Input::file('file'));
        // setting up rules
        $rules = array('file' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
           // send back to the page with the input data and errors
           return Redirect::to('upload')->withInput()->withErrors($validator);
        }
  		else {
    	   // checking file is valid.
    		if (Input::file('file')->isValid()) {
      			$destinationPath = 'uploads'; // upload path
      			$extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
      			$fileName = rand(11111,99999).'.'.$extension; // renameing image
      			Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
      			// sending back with message
      			Session::flash('success', 'Upload successfully'); 
      			return Redirect::to('upload');
   			}
    		else {
      			// sending back with error message.
      			Session::flash('error', 'uploaded file is not valid');
      			return Redirect::to('upload');
    		}
  		}
	}
}
