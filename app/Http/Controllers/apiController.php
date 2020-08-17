<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;

class apiController extends Controller
{
    //

    public function sermons() {
        // logic to get a student record goes here
        $sermons= DB::table('sermons')->get()->toJson(JSON_PRETTY_PRINT); 
       return response($sermons, 200);
      }


      public function getsermon($id) {
        // logic to get a getsermon record goes here 
        if (DB::table('sermons')->where('id',$id)->exists()) {
        $sermons= DB::table('sermons')->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT); 
       return response($sermons, 200);
        }else{

            return response()->json([
                "message" => "Sermon not found"
              ], 404);

        }
      }


      public function audios() {
        // logic to get a student record goes here
        $audios= DB::table('audios')->get()->toJson(JSON_PRETTY_PRINT); 
       return response($audios, 200);
      }

      public function getaudio($id) {
        // logic to get a getsermon record goes here 
        if (DB::table('audios')->where('id',$id)->exists()) {
        $audios= DB::table('audios')->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT); 
       return response($audios, 200);
        }else{

            return response()->json([
                "message" => "audio not found"
              ], 404);

        }
      }

      public function videos() {
        // logic to get a student record goes here
        $videos= DB::table('videos')->get()->toJson(JSON_PRETTY_PRINT); 
       return response($videos, 200);
      }

      public function getvideo($id) {
        // logic to get a getsermon record goes here 
        if (DB::table('videos')->where('id',$id)->exists()) {
        $audios= DB::table('videos')->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT); 
       return response($audios, 200);
        }else{

            return response()->json([
                "message" => "video not found"
              ], 404);

        }
      }


      public function jointquery($table1,$val1,$table2,$val2) {
        $first='';
        // logic to get a student record goes here
        $values1= DB::table($table1)->where('id',$val1)->get(); 
        foreach($values1 as $value1){

        $first.=$value1->id;
        }
    //   return response($videos, 200);
      }

   public function create_sermon(Request $request){

    $title=$request->input('title');
    $author=$request->input('author');
    $userid = Auth::guard('api')->user()->id;
    if ($request->has('fileUrl')) {

      $fileUrl = $request->get('fileUrl');
      $fileName = array_pop(explode(DIRECTORY_SEPARATOR, $fileUrl));
      $file = file_get_contents($fileUrl);
  
      $destinationPath = base_path() . '/public/upload/' . $fileName;
  
      file_put_contents($destinationPath, $file);
      
  }


    
   }

   public function users(){
     $userarray=array();
     
    $users = DB::select('select name, email from users where role !="User" ');
    foreach($users as $user){

    array_push($userarray,$user);

    }

    header("Content-Type:application/json");

    $json=json_encode($userarray,JSON_PRETTY_PRINT);
    return $json;

   
  }


  public function singleuser($id){
    $userarray=array();
    
   $users = DB::select('select name, email from users where id='.$id);
   foreach($users as $user){
    $userarray['name']=$user->name;
    $userarray['email']=$user->email;

   }
   header("Content-Type:application/json");
   $json=json_encode($userarray,JSON_PRETTY_PRINT);
   return $json;

  
 }

}
