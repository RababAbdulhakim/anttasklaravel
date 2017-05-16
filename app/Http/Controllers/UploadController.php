<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dayes;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
use Excel;
class UploadController extends Controller
{
    //
    public function create() {
        $dayes = Dayes::all();
        
        return view('upload' , compact('dayes'));
    }
    public function store() {
        $day = new Dayes;
        $file = file_get_contents("week-data.json");

        $f = json_decode($file, true);

for ($i = 0; $i < count($f); $i++) {

    for ($d = 1; $d <= count($f['daily']); $d++) {
       
$insert =Dayes::create([
        'day_id'=> $d,
         'summary'=>$f['daily']["day-" . $d]['summary'],
        'table'=> $f['daily']["day-" . $d]['table'],
         'data'=>json_encode($f['daily']["day-" . $d]['data']),
         
        ]);
     
      if($insert){
          echo "inserted";
          
      }  else{
          echo 'not inserted';
      }
        

        
    }
}
}
public function export() {
    $dayes = Dayes::all()->toArray();
    foreach ($dayes as $value) {
       $data =json_decode($value['data']);
     //  var_dump($data);
       foreach ($data as $val) {
          $newval=(array)$val;
      //    print_r($newval);
           $newdata = array(
                      "time"=> "time: ".Carbon::createFromTimestamp($newval['time'])->format('d.m.Y'),
                    "summary"=>"summary: ". $newval['summary'],
                    "icon"=>"icon: ".$newval['icon'],
                    "sunriseTime"=>"sunrise Time: ".Carbon::createFromTimestamp($newval['sunriseTime'])->format('d.m.Y'),
                    "sunsetTime"=>"sunset Time: ".Carbon::createFromTimestamp( $newval['sunsetTime'])->format('d.m.Y'),
                    "temperatureMin"=> "temperature Min: ".$newval['temperatureMin'],
                    "temperatureMinTime"=>"temperature Min Time:".Carbon::createFromTimestamp( $newval['temperatureMinTime'])->format('d.m.Y'),
                    "temperatureMax"=>"temperature Max: ".$newval['temperatureMax'],
                    "temperatureMaxTime"=>"temperature Max Time: ".Carbon::createFromTimestamp($newval['temperatureMaxTime'])->format('d.m.Y'),
           );
         $string = implode("   ", (array)$newdata); 
         
         
           $dd= array(
               
               'day_id'=>$value['day_id'],
              'table'=> $value['table'],
               'summary'=>$value['summary'],
                $keys=> $string,
               );
          //     print_r($dd);
           
       return Excel::create('dayes', function($excel) use ($dd) {
        
        $excel->sheet('mySheet', function($sheet) use ($dd)
        {
            $headings = ["day_id" , "summary" , "table" , "data"];


            $sheet->fromArray($dd);
            $sheet->prependRow(1, $headings);
        });
    })->download('xls');
       
       }
    }
     
}

public function destroy($id) {
    $delete =Dayes::find($id)->delete();
    if(isset($delete)){
        echo'true';
    }else{
        echo 'false';
    }
     //   return redirect('/uploadfile');
                        
}
}