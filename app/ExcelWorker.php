<?php

namespace App;


use Excel;
use Storage;
use App\Events\EventName;
use Redis;
use App\Events\ExcelImportWasDone;

class ExcelWorker
{
	  /**
     * Create a new job instance.
     *
     * @return void
     */
	public $path;
	public $data;

    public function __construct($path='',$data = array())
    {
        $this->path = $path;
        $this->data = $data;
    }
    public function proccess(){
    	$storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    	$path = Storage::url($this->path);
    	$path = substr($path,1,strlen($path));
    	$file = $storagePath . $this->path;
    	//dd($storagePath);
    	//$file = Storage::url($path);
    	// Create array
    	$redisArray = array();
    	$data = $this->data;
    	$indetificator = 'excel:'.$data['user_id'].':'.$data['id'];
    	//$user = Redis::get('user:excel:'.$id);
    	//Redis::set('name', 'Taylor');
    	Excel::load($file, function($reader) use ($indetificator) {
    		// Getting all results
    		//$results = $reader->get();
    		// Get workbook title
    		$workbookTitle = $reader->getTitle();
    		//$reader->dd();
			// Loop through all sheets
    		Redis::set($indetificator, $reader->toObject());
    		/*$i=1;

			$reader->each(function($sheet) use ($redisArray,$i) {
				// get sheet title
			    $sheetTitle = $sheet->getTitle();
			    $redisArray['sheet'.$i] = 
			    // Loop through all rows
			    $sheet->each(function($row) {

			    });
			    $i++;

			});
			*/

		});
		//$user = Redis::get('excel');
		//return $user;
    	$data = [
    		'indetifier'=>$indetificator,
    		'link' => '/results/'.$indetificator,
    		'message' => 'Excel proccesed'
    	];
		event(new ExcelImportWasDone($data));
    }

	function generate_array(){
		for ($i = 1; $i < 100; $i++)
		{
    		$myArray[] = array('01.01.2016','data'.$i,'data'.$i,'data'.$i,'data'.$i,'data'.$i,'data'.$i,'data'.$i,'data'.$i,'data'.$i);
		}
		return $myArray;
	}

	public function demo(){
		$array = $this->generate_array();
		Excel::create('Filename_'.rand(11111,99999), function($excel) use ($array) {
			// Set the title
    		$excel->setTitle('Our new awesome title');
    		// Chain the setters
    		$excel->setCreator('Marijan')
          		  ->setCompany('in2');
          	$array = $this->generate_array();

			$excel->sheet('Prvi sheet', function($sheet) use  ($array) {
				$sheet->freezeFirstRow();
				//$sheet->setAllBorders('thin');
				//dd($array);
				$sheet->setWidth('A', 50);
				$sheet->row(1, array(
     				'Datum', 'VR0','VR1','TEXT 1','TEXT2','VR2','VR3','TEXT3','Izmjereno 1','Izmjereno 2'
				));
				$sheet->rows($array);
			});

		})->store('xls');
		event(new EventName());
	}
}