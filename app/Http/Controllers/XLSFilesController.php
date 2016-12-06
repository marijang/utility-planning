<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Redirect;
use Session;
use Storage;
use File;
use App\Jobs\GenerateXls;
use App\Jobs\ProccessExcel;
use App\ExcelWorker;
use Excel;
use Auth;
use App\XLSFiles;
use Redis;

class XLSFilesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    $user = Auth::user();
		$entries = XLSFiles::where('user_id',$user->id)->get();
		return view('pages.index', compact('entries'));
	}

  public function downloadTemplate(){
    //return storage_path();
   // return Storage::disk('local')->get();
    $file = Storage::disk('local')->get('/templates/template.xls');
    return (response($file, 200))
              ->header('Content-Type', 'application/vnd.ms-excel')
              ->header("Content-disposition", "attachment; filename=mojexcel.xls")
              ;
    //return response()->download($pathToFile);
  }

   public function download($id){
    $user = Auth::user();
    $entry = XLSFiles::where('user_id',$user->id)->where('id',$id)->first();

    $userDir = 'user_'.$user->id;
    $file = Storage::disk('local')->get('/'.$userDir.'/'.$entry->filename);
    return (response($file, 200))
              ->header('Content-Type', 'application/vnd.ms-excel')
              ->header("Content-disposition", "attachment; filename=".$entry->filename)
              ;
    //return response()->download($pathToFile);
  }

  public function results($id){
      $excel = Redis::get($id);
      return $excel ;
  }


	public function demo(){
		
    $job = (new GenerateXls( new ExcelWorker() ))->onQueue('default');
    $this->dispatch($job);

    return 'ok';

	}

    public function upload(Request $request) {
  		// getting all of the post data
  		$files = array('file' => $request->file('file'));
      $user = Auth::user();
      $userDir = 'user_'.$user->id;
  		$file = $request->file('file');
        // setting up rules
        $rules = array('file' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000 |mimes:xls,xlsx
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($files, $rules);
        if ($validator->fails()) {
           // send back to the page with the input data and errors
           Session::flash('error', 'uploaded file is not valid');
           return Redirect::to('upload')->withInput()->withErrors($validator);
        }
  		else {
    	   // checking file is valid.
    		if ($request->file('file')->isValid()) {
      		
      			$extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
      			$fileName = 'datoteka_'.microtime().'.'.$extension; // renameing image
      			//$request->file('file')->move($destinationPath, $fileName); // uploading file to given path
      			Storage::disk('local')->put('/'. $userDir.'/'.$fileName,  File::get($file));
            // Store
            $fileManager = new XLSFiles();
            $fileManager->user_id = $user->id;
            $fileManager->filename = $fileName;
            $fileManager->mime = $file->getMimeType();
            $fileManager->save();

            $data = array();
            $data['user_id'] = $user->id;
            $data['id']= $fileManager->id;
            $indetificator = 'excel:'.$data['user_id'].':'.$data['id'];
            $fileManager->redis_url = $indetificator;
            $fileManager->save();

      			// sending back with message
      			Session::flash('success', 'Upload successfully'); 
            // Execute job
            $worker = new ExcelWorker(''. $userDir.'/'.$fileName,$data);
           // return $worker->proccess(); 
            $job = (new ProccessExcel( $worker ))->onQueue('default');
            $this->dispatch($job);
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
