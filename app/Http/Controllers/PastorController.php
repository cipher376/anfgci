<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\sermons;
use App\resources;
use App\Location ;
use App\churches;
use App\pastors;
use App\photos;
use App\church_services;
use App\church_photos;
use App\audios;

class PastorController extends Controller
{
    //

    public function index()
    {
        
       
        $sermonsX= DB::table('sermons')->where('userID',auth()->user()->id)->get(); 
        
        $churches = DB::table('churches')->get();
        $users = DB::table('users')->get();
       
        return view('pastor.index',['sermonsx'=>$sermonsX],['churches'=>$churches],['users'=>$users]);
    }

    public static function allVideos(){

                
        $videos= DB::table('videos')->where('userID',auth()->user()->id)->get(); 

        return $videos;

      }

      public static function allAudios(){

        $audios= DB::table('audios')->where('userID',auth()->user()->id)->get(); 
        
        return $audios;
        
               
    
                  }


    public function sermons()
    {

        $sermons= DB::table('sermons')->where('userID',auth()->user()->id)->get(); 
     
    return view('pastor.sermon',['sermons'=>$sermons]);

    }

    public function add_sermons()
    {
        return view('pastor.add_sermon');
    }

    public function show($id)
    
    {
        $sermons = DB::select('select * from sermons LEFT JOIN resources USING (resourceID) where sermonID='.$id);
     
    return view('pastor.view',['sermons'=>$sermons]);
       
    }


    public function addPhoto($id)
    {
        $churches = DB::select('select * from churches where churchID='.$id);
        return view('pastor.add_photo',['churches'=>$churches]);
    }



    public function add_photo($id){

        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'caption'=>'required|string',
            'file' => 'required|mimes:jpeg,JPEG,png',
            
            ],
            [
               
                ]);

                if(count(request()->all()) > 0){
                 $dbchid=[];

                     ////// move file to upload folder ////////////////

                     $file = request()->file('file');
                     $original_name = strtolower(trim($file->getClientOriginalName()));
                     $fileName =  time().rand(100,999).$original_name;
                     $filePath = 'churchPhoto';
                     $file->move($filePath,$fileName);

                     //insert photo into photo table /////////////

                     $photos = new photos();

                        $photos->type= '2';
                        $photos->title= request()->input('title');
                        $photos->caption= request()->input('caption');
                        $photos->url='/churchPhoto/'.$fileName;
                       if($photos->save()){

                        $churches = DB::select('select * from churches where churchID='.$id);
                        foreach($churches  as $church){
                
                        $dbchid[]= json_decode($church->photoID,true);
                
                
                        }
                        
                       array_push($dbchid, $photos->id);


                       }

                       DB::table('churches')->where('churchID', $id)->update(['photoID'=>json_encode($dbchid)]);
                       return redirect()->back()->withSuccess('Photo uploaded succesfully');

                    } else{


                        
                        return redirect()->back()->withErrors($validator)->withInput();



                    }      

    }





    public function store_photo($id)
    {

        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'caption'=>'required|string',
            'file' => 'required|mimes:jpeg,JPEG,png',
            ],
            [
                'title.required'=>'Enter a title for the photo you want to upload ',
                'caption.required'=>'Enter a caption for your photo  ',
                'file.required'=>'Please Upload a photo ',
                
                
                ]);


                if(count(request()->all()) > 0){

                    ////// move file to upload folder ////////////////

                    $file = request()->file('file');
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $fileName =  time().rand(100,999).$original_name;
                    $filePath = 'churchPhoto';
                    $file->move($filePath,$fileName);
        
                    //////////// create data //////////////////////
        
                    $title = request()->input('title');
                    $caption = request()->input('caption');
                    $church = request()->input('church');
                    $files =  $fileName;
                    $created= date('Y-m-d H:i:s');
                    $data=array('title'=>$title,"caption"=>$caption,"filename"=>$files,"church_id"=>$church,'created_at'=>$created);
                    DB::table('church_photos')->insert($data);
        
        
                   ////////// redirect to url //////////////////////////
        
                   return redirect()->back()->withSuccess('Photo uploaded succesfully');
                        
                    }else{
        
        
                         return redirect()->back()->withErrors($validator)->withInput();
        
                    }


       
    }



    public function destroy($id)
    
    {
        $sermons = DB::delete('delete from sermons where sermonID='.$id);
        return redirect()->back()->withSuccess('one record deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }
    



    public function store_sermons()
    {
        //1.validate data
        
        $validator=$this->validate(request(),[
        'topic'=>'required|string',
        'author'=>'required|string',
        'sermon'=>'required|string',
        'file' => 'required|mimes:pdf,docx,doc',
        ],
        [
            'topic.required'=>'Type in Topic of the Sermon you want to Upload ',
            'author.required'=>'Type in Author of Sermon ',
            'sermon.required'=>'Enter Sermon ',
            'file.required'=>'Please Upload a PDF file ',
            
            
            ]);

            if(count(request()->all()) > 0){

            ////// move file to upload folder ////////////////

            $file = request()->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'upload';
            $filePathdb='upload/'.$fileName;
            $file->move($filePath,$fileName);
            $user = auth()->user()->id;

            //////////// create data //////////////////////

           

            $sermons = new sermons;

            $resource = new resources;

            $resource->title = request()->input('topic');
            $resource->type = 4;
            
            $resource->note = request()->input('sermon');
            $resource->url =$filePathdb;
            $resource->isPublic= 0;
            $resource->uploadby=auth()->user()->name;
            $resource->artist = request()->input('author');
           
                   if($resource->save()){
                    $sermons->topic = request()->input('topic');
                    $sermons->author = request()->input('author');
                    $sermons->userID = auth()->user()->id;
                    $sermons->resourceID = $resource->id;
                    $sermons->status = 0;
                    $sermons->postedBy = auth()->user()->name;
                    $sermons->save();

                       

                    }     
                
           


           ////////// redirect to url //////////////////////////

           return redirect()->back()->withSuccess('Sermon uploaded succesfully !');
                
            }else{


                 return redirect()->back()->withErrors($validator)->withInput();

            }
                ///// move uploaded file to folder


           

            
        //2. create data

        //3. redirect url

            
    }



    public function update($id)
    
    {
        $validator=$this->validate(request(),[
            'topic'=>'required|string',
            'author'=>'required|string',
            'sermon'=>'required|string',
            //'file' => 'required|mimes:pdf,docx,doc',
            ],
            [
                'topic.required'=>'Type in Topic of the Sermon you want to Upload ',
                'author.required'=>'Type in Author of Sermon ',
                'sermon.required'=>'Enter Sermon ',
               // 'file.required'=>'Please Upload a PDF file ',
                
                
                ]);

                if(count(request()->all()) > 0){

                    $file = request()->file('file');
                    $topic = request()->input('topic');
                    $author= request()->input('author');
                    $sermon= request()->input('sermon');

                    $resid="";
                    if(empty($file)){
                        
                        DB::table('sermons')->where('sermonID', $id)->update(['topic' => $topic, 'author' => $author]);
                        
                        $sermonsups = DB::select('select * from sermons where sermonID='.$id);
                        foreach($sermonsups as $sermonsup){

                            $resid=$sermonsup->resourceID;
                        }
                        DB::table('resources')->where('resourceID',  $resid)->update(['title' => $topic, 'artist' => $author,'note' => $sermon]);
                        
                        //$sermons = DB::select('select * from sermons where sermonID='.$id);
     
                        //return view('manage.edit_sermon',['sermons'=>$sermons]);

                        return redirect()->back()->withSuccess('Update succesful.');
                    
                    }
                    else{ 
                        
                        ///// remove the existing file from folder /////////

                    $existFile=""; 

                    $sermonsups = DB::select('select * from sermons where sermonID='.$id);
                    foreach($sermonsups as $sermonsup){

                        $resid=$sermonsup->resourceID;
                    }
                    
                   
                   $resources= DB::table('resources')->where('resourceID', $resid)->get(); 
                    foreach($resources as $resource){
            
                        $existFile=$resource->url;
            
                    }

                    if(file_exists(public_path($existFile))){

                        unlink(public_path($existFile));
                  
                      }
                   
                  
                    //////// move file to upload folder ////////////////

            $original_name = strtolower(trim($file->getClientOriginalName()));
            $fileName =  time().rand(100,999).$original_name;
            $filePath = 'upload';
            $filePathdb = '/upload/'.$fileName;
            $file->move($filePath,$fileName);
                
            $sermon2= request()->input('sermon');
            //////////////// update database with new information ///////

           DB::table('resources')->where('resourceID', $resid)->update(['title'=>$topic, 'artist' => $author,'note' =>$sermon2,'url'=> $filePathdb]);
                              
            

           return redirect()->back()->withSuccess('Update succesful.');






                    }



                }
       
    }

    public function edit($id)
    
    {
        $sermons = DB::select('select * from sermons left join resources using(resourceID) where sermonID='.$id);
     
     
    return view('pastor.edit_sermon',['sermons'=>$sermons]);
       
    }



    public function churches()
    {
        $pastorRight="";
        //$pastors = DB::select('select * from pastors where id='.auth()->user()->id);
        $pastors= DB::table('pastors')->where('userID', auth()->user()->id)->get(); 
        if($pastors->count()>0){

            foreach($pastors as $pastor){

                $pastorRight=$pastor->pastorRight;
            }

        $churches = DB::select('select * from pastors left join churches using(churchID) where userID='.auth()->user()->id.' order by churchID DESC');
      
        }else{
            $churches=array();;

        }
          return view('pastor.churches',['churches'=>$churches]);

    }

    public function add_church()
    {
        return view('pastor.add_church');
    }



    public function destroyChurch($id)
    
    {
        $sermons = DB::delete('delete from churches where churchID='.$id);
        $pastor = DB::delete('delete from pastors where churchID='.$id);
        
        return redirect()->back()->withSuccess('one record deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function showChurchservices($id){


        $churches = DB::select('select * from churches where churchID='.$id);
        //$services = church_services::where('churchID', '=', $id)->first();
        $services = DB::table('church_services')->where('churchID', $id)->paginate();

        return view('pastor.view_church_service',['services'=>$services],['churches'=>$churches]);


    }

    public function events($id){
        
        $churches = DB::select('select * from churches where churchID='.$id);
        $events= DB::table('events')->where('churchID', $id)->paginate();
        
        return view('pastor.events',['events'=>$events],['churches'=>$churches]);

    }




    public function edit_event($id,$id2){


        $churches= DB::table('churches')->where('churchID', $id)->get();
  
  
        $event= DB::table('events')
        ->select('events.eventID','events.title','events.note','events.author','events.startTime','events.endTime','address.country','address.state','address.town')
        ->join('address','address.addressID','=','events.addressID') 
        ->where(['eventID' => $id2])
          ->first();
       
        return view('pastor.edit_event',['event'=>$event],['churches'=>$churches]);
              
      }

      public function pastor_list($id)
    {
        $churches = DB::select('select * from churches where churchID='.$id);  
        $pastors= DB::select('select * from pastors where churchID='.$id);
       
        return view('pastor.pastor_list',['churches'=>$churches],['pastors'=>$pastors]);
    }


      public function usersettings($id){

        $churches = DB::select('select * from churches where churchID='.$id);
        return view('pastor.user_settings',['churches'=>$churches]);
    }

      public function add_report($id){
       
        return view('pastor.add_report',['church'=>$id]);
    }

      public function church_report($id){
        $reports= DB::table('reports')
        ->select('resources.title','resources.url','resources.created_at','reports.reportMonth','reports.churchID','reports.id')
        ->join('resources','resources.resourceID','=','reports.resourceID')
        ->where(['churchID' => $id])
        ->get();
        return view('pastor.church_report',['reports'=>$reports],['church'=>$id]);
    }



    public function eventDetail($id,$id2)
    
    {
        //$existFile=""; 
        //$photos = photos::where('photoID', '=', $id)->first();
       // $existFile.= $photos->url;
            
                    

                  //  if(file_exists(public_path($existFile))){

                     //   unlink(public_path($existFile));
                  
                    //  }

         $churches= DB::table('churches')->where('churchID', $id)->get();
        $event= DB::table('events')->where('eventID', $id2)->first();
       
       

        return view('pastor.event_detail',['event'=>$event],['churches'=>$churches]);
       
    }


    public function serviceSermonx($id,$id2){
       
        $sermonid="";
        $churchServices=DB::table('church_services')->where('serviceID', $id2)->get();
        foreach($churchServices as $churchService){
        $sermonid=$churchService->sermonID;
        }
        $sermons = DB::select('select * from sermons left join resources using(resourceID) where sermonID='.$sermonid);
        $churches = DB::select('select * from churches where churchID='.$id);
       
        return view('pastor.service_sermon',['sermons'=>$sermons],['churches'=>$churches]);
    
       }


    public function store_churches()
    {
        //1.validate data
        
        $validator=$this->validate(request(),[
        'name'=>'required|string',
        'est_date'=>'required|string',
        'country'=>'required|string',
        'state'=>'required|string',
        'town'=>'required|string',
        'note'=>'required|string',
        
        ],
        [
            'name.required'=>'Type in the name of branch you want to upload information for. ',
            'est_date.required'=>'Enter the date of establishment. ',
            'country.required'=>'Select country. ',
            'state.required'=>'Enter the state.',
            'phone.required'=>'Enter branch phone number. ',
            'email.required'=>'Enter email. ',
            'note.required'=>'Type a brief description  or any other information you want to add in the Note field. ',
            
            
            ]);

            if(count(request()->all()) > 0){
            $myArray = [];
            $user = auth()->user()->id;
            $photo=json_encode($myArray);
            $church=json_encode($myArray);

            $address = new Location;

            $address->country = request()->input('country');
            $address->state = request()->input('state');
            $address->town = request()->input('town');
            $address->lat= "";
            $address->lng= "";
           
           if($address->save()){



            $churches = new churches;
            $churches->name = request()->input('name');
            $churches->pastor = auth()->user()->name;
            $churches->id = auth()->user()->id;
            $churches->note= request()->input('note');
            $churches->addressID = $address->id;
            $churches->photoID = $photo;
            $churches->churchserviceID = $church;
            $churches->est_date = request()->input('est_date');
            if($churches->save()){
            


            $pastors = new pastors;
            $pastors->churchID = $churches->id;
            $pastors->userID = auth()->user()->id;
            $pastors->pastorRight =1;
            $pastors->save();
           

           }
          
        }
           

           return redirect()->back()->withSuccess('Church created succesfully !');
                
            }else{


                 return redirect()->back()->withErrors($validator)->withInput();

            }
              

            
    }


    public function churchEdit($id)
    
    {
        $churches = DB::select('select * from churches LEFT JOIN address USING(addressID) where churchID='.$id);
     
    return view('pastor.edit_church',['churches'=>$churches]);
       
    }



    


    public function churchUpdatepastor($id)
    
    {
        $validator=$this->validate(request(),[
            'name'=>'required|string',
            'est_date'=>'required|string',
            'country'=>'required|string',
            'state'=>'required|string',
            'town'=>'required|string',
            'note'=>'required|string',
            
            ],
            [
                'name.required'=>'Type in the name of church branch you want to upload information for ',
                'est_date.required'=>'Enter the date of establishment ',
                'country.required'=>'Select country',
                'state.required'=>'Enter the state where church is located',
                'town.required'=>'Enter the town where church is located',
                'note.required'=>'Type a brief description  or any other information you want to add in the Note field ',
                
                
                ]);

                if(count(request()->all()) > 0){

                   
                    $name = request()->input('name');
                    $est_date= request()->input('est_date');
                    $country = request()->input('country');
                    $state= request()->input('state');
                    $town= request()->input('town');
                    $pastor = request()->input('pastor');
                    $note= request()->input('note');


                        
                    $pullchurchs = DB::select('select * from churches where churchID='.$id);
                    foreach($pullchurchs as $pullchurch){

                        DB::table('address')->where('addressID', $pullchurch->addressID)->update(['country' =>request()->input('country'), 'state' => request()->input('state'),'town' => request()->input('town')]);
                    

                    }

                    DB::table('churches')->where('churchID', $id)->update(['name' => $name, 'est_date' => $est_date,'note' => $note]);
                   
                    $churches = DB::select('select * from churches where churchID='.$id);
                    return redirect()->back()->withSuccess('Update succesful.');
                    
                  
                   



                }
       
    }


    public function photodetail($id){
        $cp = church_photos::where('photoID', '=', $id)->first();
        $churches = DB::select('select * from churches where churchID='.$cp->churchID);
     
        

        $photos = photos::where('photoID', '=', $id)->first();
        return view('pastor.view_photo_detail',['photos'=>$photos],['churches'=>$churches]);

    }


    public function album($id)
    {
        $churches = DB::select('select * from churches left join address using(addressID) where churchID='.$id);  
        //$photos= DB::select('select * from church_photos left join photos using (photoID) where churchID='.$id);
       
        $photos= DB::table('church_photos')
        ->select('photos.photoID','photos.title','photos.created_at','photos.caption','photos.url')
        ->join('photos','photos.photoID','=','church_photos.photoID') 
        ->where(['churchID' => $id])
        ->paginate(9);
    


        return view('pastor.photo_album',['churches'=>$churches],['photos'=>$photos]);
    }


    public function showChurch($id)
    
    {
        $churches = DB::select('select * from churches left join address using(addressID) where churchID='.$id);
        $photos = DB::select('select * from church_photos left join photos using(photoID) where churchID='.$id);
        
       
        
        
    return view('pastor.view_church',['churches'=>$churches],['photos'=>$photos]);
       
    }
    function addService($id){

        
        
        

        $created= date('Y-m-d H:i:s');

        $church_services = new church_services;
        $church_services->title = request()->input('title');
        $church_services->month = request()->input('month');
        $church_services->time = request()->input('time');
        $church_services->churchID = $id;
        $church_services->postedBy =auth()->user()->id;
        $church_services->sermonID = "";
        $church_services->created_at = $created;
        $church_services->save();


       return redirect()->back()->withSuccess('Update succesful.');


          

}  


public function pullservices($id){

   // $services = DB::select('select * from church_services where churchID='.$id);
    $services= DB::table('church_services')->where('churchID', $id)->get(); 
     
    return view('pastor.church_services',['services'=>$services]);

}

public function deleteServices($id) {
        

        DB::table('church_services')->where('serviceID', $id)->delete();
        return redirect()->back()->withSuccess('service deleted succesfuly.');

       // $services = DB::select('select * from church_services where churchID='.$id);
       // return view('pastor.church_services',['services'=>$services]);
       
    }


   public function serviceSermon($id){
    $title="";
    $month="";
    $churchServices=DB::table('church_services')->where('serviceID', $id)->get();
    foreach($churchServices as $churchService){
    $title=$churchService->title;
    $month=$churchService->month;
    }
    $head=ucwords($title)." | ".$month;
    return view('pastor.service_sermon',['service'=>$id],['header'=>$head]);

   }


   public function storeSermons()
    {
        //1.validate data
        
        $validator=$this->validate(request(),[
        'topic'=>'required|string',
        'author'=>'required|string',
        'sermon'=>'required|string',
        'file' => 'required|mimes:pdf,docx,doc',
        ],
        [
            'topic.required'=>'Type in Topic of the Sermon you want to Upload. ',
            'author.required'=>'Type in Author of Sermon. ',
            'sermon.required'=>'Enter Sermon. ',
            'file.required'=>'Please Upload a PDF file. ',
            
            
            ]);

            if(count(request()->all()) > 0){

            ////// move file to upload folder ////////////////

            $file = request()->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'upload';
            $filePathdb='/upload/'.$fileName;
            $file->move($filePath,$fileName);
            $user = auth()->user()->id;

            //////////// create data //////////////////////

           

            $sermons = new sermons;

                    $sermons->topic = request()->input('topic');
                    $sermons->author = request()->input('author');
                    $sermons->userID = auth()->user()->id;
                    $sermons->resourceID = 0;
                    $sermons->status = 0;
                    $sermons->postedBy = auth()->user()->name;
                    if($sermons->save()){


                        $resource = new resources;

                        $resource->title = request()->input('topic');
                        $resource->type = 4;
                        
                        $resource->note = request()->input('sermon');
                        $resource->url =$filePathdb;
                        $resource->sermonID= $sermons->id;
                        $resource->isPublic= 0;
                        $resource->uploadby=auth()->user()->name;
                        $resource->artist = request()->input('author');
                        $resource->save();

                        DB::table('church_services')->where('serviceID', request()->input('serviceid'))->update(['sermonID'=>$sermons->id]);
       

                    }     
                
           


           ////////// redirect to url //////////////////////////

           return redirect()->back()->withSuccess('Sermon uploaded succesfully !');
                
            }else{


                 return redirect()->back()->withErrors($validator)->withInput();

            }
                ///// move uploaded file to folder


           

            
        //2. create data

        //3. redirect url

            
    }


    public function postallow(Request $request){
        switch ($request->input('action')) {
            case 'activate':
                
    
                if(isset($_POST['sermon'])){
                    if (is_array($_POST['sermon'])) {
                         foreach($_POST['sermon'] as $value){
                            DB::table('sermons')->where('sermonID', $value)->update(['status' => '1']);
                         }
    
                         return redirect()->back()->withSuccess('Sermon set to active mode sucessfuly.');
    
                      } else {
                        $value = $_POST['sermon'];
                        DB::table('sermons')->where('sermonID', $value)->update(['status' => '1']);
                        return redirect()->back()->withSuccess('Sermon set to active mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one sermon to activate');
               }
    
                       
    
    
                break;
    
            case 'deactivate':
                
                if(isset($_POST['sermon'])){
                    if (is_array($_POST['sermon'])) {
                         foreach($_POST['sermon'] as $value){
                            DB::table('sermons')->where('sermonID', $value)->update(['status' => '0']);
                         }
    
                         return redirect()->back()->withSuccess('Sermon set to inactive mode sucessfuly.');
    
                      } else {
                        $value = $_POST['sermon'];
                        DB::table('sermons')->where('sermonID', $value)->update(['status' => '0']);
                        return redirect()->back()->withSuccess('Sermon set to inactive mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one sermon to deactivate');
               }
    
    
                break;
    
            
        }
    }


    public function videopostallow(Request $request){
        switch ($request->input('action')) {
            case 'activate':
                
    
                if(isset($_POST['video'])){
                    if (is_array($_POST['video'])) {
                         foreach($_POST['video'] as $value){
                            DB::table('videos')->where('videoID', $value)->update(['status' => '1']);
                         }
    
                         return redirect()->back()->withSuccess('Video set to active mode sucessfuly.');
    
                      } else {
                        $value = $_POST['video'];
                        DB::table('videos')->where('videoID', $value)->update(['status' => '1']);
                        return redirect()->back()->withSuccess('Video set to active mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one video to activate');
               }
    
                       
    
    
                break;
    
            case 'deactivate':
                
                if(isset($_POST['video'])){
                    if (is_array($_POST['video'])) {
                         foreach($_POST['video'] as $value){
                            DB::table('videos')->where('videoID', $value)->update(['status' => '0']);
                         }
    
                         return redirect()->back()->withSuccess('video set to inactive mode sucessfuly.');
    
                      } else {
                        $value = $_POST['video'];
                        DB::table('videos')->where('videoID', $value)->update(['status' => '0']);
                        return redirect()->back()->withSuccess('Video set to inactive mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one video to deactivate');
               }
    
    
                break;
    
            
        }
    }
    public function searchquery(Request $request){
        $searchterm = $request->input('search-term');
        
        $searchresults = DB::table('sermons')->where('topic', 'like', $searchterm.'%')->get();

        return view('pastor.search',['sermons'=>$searchresults]);



    }

    public function profile($id){
        $profiles = DB::select('select * from profile left join users using(id)  left join photos using (photoID) left join address using(addressID) where id='.$id);
        return view('pastor.profile_view',['profiles'=>$profiles]);  

    }


    public function update_user($id){

        //1.validate data
           
        $validator=$this->validate(request(),[
           'firstname'=>'required|string',
           'lastname'=>'required|string',
           'phone'=>'required|string',
           'town'=>'required|string',
           'state'=>'required|string',
           'country'=>'required|string',
           
           
           ]);
   
               if(count(request()->all()) > 0){
   
                  
                   $addressid="";
   
   
                   if(empty( request()->file('file'))){
   
                       
                       //$profiles = DB::select('select * from profile where id='.auth()->user()->id);
                       $profiles =  DB::table('profile')->where('id',$id)->get();
                       foreach($profiles as $profile){
   
                           $addressid.=$profile->addressID;   
                       }
   
                DB::table('profile')->where('id',$id)->update(['firstname' => request()->input('firstname'), 'lastname' => request()->input('lastname'), 'phone' => request()->input('phone')]);
                DB::table('address')->where('addressID', $addressid)->update(['town' => request()->input('town'), 'state' => request()->input('state'), 'country' => request()->input('country')]);
               
                    
                   
                       return redirect()->back()->withSuccess('Update succesful.');
                   
                   }
                   else{ 
   
   
   
   
   
                         ///// remove the existing file from folder /////////
   
                         $existFile=""; 
   
                         $profile=DB::table('profile')
                         ->select('profile.id','photos.url','address.addressID','photos.photoID')
                         ->join('photos','photos.photoID','=','profile.photoID') 
                         ->join('address','address.addressID','=','profile.addressID') 
                         ->where(['id' => $id])
                         ->first();
   
                        
     
                             $addressid=$profile->addressID;
                             $existFile.=$profile->url; 
                               
                        
   
     
                         if(file_exists(public_path('profilePhoto/'.basename($existFile)))){
     
                             unlink(public_path('profilePhoto/'.basename($existFile)));
                       
                           }
                        
                       
                         //////// move file to upload folder ////////////////
                   $file=request()->file('file');
                 $original_name = strtolower(trim($file->getClientOriginalName()));
                 $fileName =  time().rand(100,999).$original_name;
                 $filePathdb = asset('/profilePhoto/'.$fileName);
                 $filePath = 'profilePhoto';
                 $file->move($filePath,$fileName);
                     
     
                 //////////////// update database with new information ///////
     
                 DB::table('profile')->where('id',$id)->update(['firstname' => request()->input('firstname'), 'lastname' => request()->input('lastname'), 'phone' => request()->input('phone')]);
                DB::table('address')->where('addressID', $addressid)->update(['town' => request()->input('town'), 'state' => request()->input('state'), 'country' => request()->input('country')]);
                DB::table('users')->where('id', $id)->update(['role' => request()->input('role')]);
                DB::table('photos')->where('photoID', $profile->photoID)->update(['url' => $filePathdb]);
               
                          
     
                return redirect()->back()->withSuccess('Update succesful.');
                       
                  
               
                   }}
   
   }

    public function allvideo()
    {
        
        $videos = DB::select('select * from videos left join resources using (resourceID) where userID='.auth()->user()->id.' and vidType="free" ');
        return view('pastor.video_list',['videos'=>$videos]);
    }


    public function video()
    {
        
        return view('pastor.add_videos');
    }

    public function premiumvideo(){

        $videos = DB::select('select * from videos left join resources using(resourceID) where userID='.auth()->user()->id.' and vidType="premium"');
        return view('pastor.premium_videos',['videos'=>$videos]);

    }


    public function delete_video($id)
    
    {
        
$resid="";
$existFile="";
       

   $videos= DB::table('videos')->where('videoID', $id)->get();
        foreach($videos as $video){

        $resid=$video->resourceID;

        }

   $resources= DB::table('resources')->where('resourceID', $resid)->get(); 
   foreach($resources as $resource){

       $existFile=$resource->url;

   }

   if(file_exists(public_path($existFile))){

       unlink(public_path($existFile));
 
     }


     DB::table('videos')->where('videoID', $id)->delete();
     DB::table('resources')->where('resourceID', $resid)->delete();
     return redirect()->back()->withSuccess('video deleted succesfuly.');

       
    }


    public function add_premium()
    {
        
        return view('pastor.add_premium_video');
    }


    public function storePremiumVideos()    
    {
        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'author'=>'required|string',
            'note'=>'required|string',
            'videofile'=>'required|file:mp4',
           
            
            
            ],
            [
                'title.required'=>'Enter video title ',
                'author.required'=>'Enter author name ',
                'note.required'=>'Enter a note for audio ',
                'videofile.required'=>'Upload a video',
                
                
                ]);

                if(count(request()->all()) > 0){

                   
                    $title = request()->input('title');
                    $author = request()->input('author');
                    $note= request()->input('note');
                    $videofile= request()->file('videofile');
                    $created= date('Y-m-d H:i:s');

             //////// move videofile to audios folder ////////////////

             $original_videoname = strtolower(trim($videofile->getClientOriginalName()));
             $fileName =  time().rand(100,999).$original_videoname;
             $filePath = 'premiumVideos';
             $filePathdb = '/premiumVideos/'.$fileName;
             $videofile->move($filePath,$fileName);

             $resource = new resources;

             $resource->title = request()->input('title');
             $resource->type = 1;
             
             $resource->note = request()->input('note');
             $resource->url =$filePathdb;
             $resource->isPublic= 0;
             $resource->uploadby=auth()->user()->name;
             $resource->artist = request()->input('author');
             if($resource->save()){


             $data=array('resourceID'=>$resource->id,'vidType'=>"premium","userID"=>auth()->user()->id,"status"=>'0',"created_at"=>$created);
             DB::table('videos')->insert($data);
     

                return redirect()->back()->withSuccess('upload succesful.');
                    
             }    
                   



                }
       
    }
    public function delete_free_video($id)
    
    {
        $resourceID="";
        $videos = DB::select('select * from videos where videoID='.$id);
        foreach($videos as $video){

            $resourceID=$video->resourceID;
        }
       
        DB::table('videos')->where('videoID', $id)->delete();
        DB::table('resources')->where('resourceID',  $resourceID)->delete();

        return redirect()->back()->withSuccess('video deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function add_video()
  {

      $validator=$this->validate(request(),[
          'title'=>'required|string',
          'artist'=>'required|string',
          'note' => 'required|string',
          'id' => 'required|string',
          ],
          [
              'title.required'=>'Enter a title for video. ',
              'artist.required'=>'Enter name for authur.  ',
              'note.required'=>'Enter name for note.  ',
              'id.required'=>'enter video ID. ',
              
              
              ]);


              if(count(request()->all()) > 0){

                $title = request()->input('title');
                $artist = request()->input('artist');
                $note= request()->input('note');
                $vid= request()->input('id');
                $created= date('Y-m-d H:i:s');


                $resource = new resources;

                        $resource->title = request()->input('title');
                        $resource->type = 1;
                        
                        $resource->note = request()->input('note');
                        $resource->url =request()->input('id');
                        $resource->isPublic= 0;
                        $resource->uploadby=auth()->user()->name;
                        $resource->artist = request()->input('artist');
                        if($resource->save()){

                $data=array('resourceID'=>$resource->id,'vidType'=>"free","userID"=>auth()->user()->id,"status"=>'0');
                DB::table('videos')->insert($data);
                return redirect()->back()->withSuccess('Upload sucessful.');
                        }
               

              }}




              public function audios()
              {
                 $audios = DB::select('select * from audios left join resources using(resourceID)  where userID='.auth()->user()->id.' ');
                 // $audios= DB::table('audios')->get();
                
                  return view('pastor.audios',['audios'=>$audios]);
              }

              public function add_audio()
    {
        return view('pastor.add_audio');
    }



    public function store_audio()    
    {
        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'artist'=>'required|string',
            'note'=>'required|string',
            'type'=>'required|string',
            'imgfile'=>'required|mimes:jpeg,JPEG,png',
            'audiofile'=>'required|file:mp3,wav,MP3',
           
            
            
            ],
            [
                'title.required'=>'Enter audio title. ',
                'artist.required'=>'Enter artist name. ',
                'note.required'=>'Enter a note for audio. ',
                'imgfile.required'=>'Upload photo for audio.',
                'audiofile.required'=>'Upload an audio',
                
                
                ]);

                if(count(request()->all()) > 0){

                   
                    $resourceid="";
                    $imgfile= request()->file('imgfile');
                    $audiofile= request()->file('audiofile');

                

                      //////// move imgfile to photos folder ////////////////

            $original_filename = strtolower(trim($imgfile->getClientOriginalName()));
            $fileName =  time().rand(100,999).$original_filename;
            $filePath = 'photos';
            $filePathdb = '/photos/'.$fileName;
            $imgfile->move($filePath,$fileName);

             //////// move audiofile to audios folder ////////////////

             $original_audioname = strtolower(trim($audiofile->getClientOriginalName()));
             $fileName2 =  time().rand(100,999).$original_audioname;
             $filePath2 = 'audios';
             $filePath2db = '/audios/'.$fileName2;
             $audiofile->move($filePath2,$fileName2);


             $resource = new resources;

             $resource->title = request()->input('title');
             $resource->type = 2;
             
             $resource->note = request()->input('note');
             $resource->url =$filePath2db;
             $resource->isPublic= 0;
             $resource->uploadby=auth()->user()->name;
             $resource->artist = request()->input('artist');
             if($resource->save()){
                $resourceid=$resource->id;

                $photos = new photos();

                        $photos->type= '4';
                        $photos->title= request()->input('title');
                        $photos->caption= "cover photo";
                        $photos->url=$filePathdb;
                       if($photos->save()){



                        $audios = new audios;

                        $audios->resourceID=$resourceid;
                        $audios->userID=auth()->user()->id;
                        $audios->audioType=request()->input('type');
                        $audios->photoID=$photos->id;
                        $audios->status=0;
                        $audios->save();
     

                return redirect()->back()->withSuccess('Audio upload succesful.');


             }
                    
                  
                   



                }
       
    }

}

public static function showAudioCover($id){
    $photourl="";

    $audios = DB::select('select * from audios left join resources using(resourceID)  where audioID ='.$id.' ');
    foreach($audios as $audio){

       $photos= DB::select('select * from photos where photoID='.$audio->photoID);
       foreach($photos as $photo){
           $photourl=$photo->url;

       }
       return $photourl;

}
}


public static function showAudiotitle($id){
    $resourcetitle="";

    $resources = DB::select('select * from  resources where resourceID ='.$id);
    foreach($resources as $resource){

      
           $resourcetitle=$resource->artist;

       }
      


return $resourcetitle;
}




public function audioallow(Request $request){
    switch ($request->input('action')) {
        case 'activate':
            

            if(isset($_POST['audio'])){
                if (is_array($_POST['audio'])) {
                     foreach($_POST['audio'] as $value){
                        DB::table('audios')->where('audioID', $value)->update(['status' => '1']);
                     }

                     return redirect()->back()->withSuccess('Audio set to active mode sucessfuly.');

                  } else {
                    $value = $_POST['audio'];
                    DB::table('audios')->where('audioID', $value)->update(['status' => '1']);
                    return redirect()->back()->withSuccess('Audio set to active mode sucessfuly.');
               }
           }else{


            return redirect()->back()->withErrors('Please check atleast one Audio to activate');
           }

                   


            break;

        case 'deactivate':
            
            if(isset($_POST['audio'])){
                if (is_array($_POST['audio'])) {
                     foreach($_POST['audio'] as $value){
                        DB::table('audios')->where('audioID', $value)->update(['status' => '0']);
                     }

                     return redirect()->back()->withSuccess('Audios set to inactive mode sucessfuly.');

                  } else {
                    $value = $_POST['audio'];
                    DB::table('audios')->where('audioID', $value)->update(['status' => '0']);
                    return redirect()->back()->withSuccess('Audio set to inactive mode sucessfuly.');
               }
           }else{


            return redirect()->back()->withErrors('Please check atleast one audio to deactivate');
           }


            break;

        
    }
}


public function delete_audio($id)
    
{
    
   


    $imgFile="";
    $audioFile=""; 
        
    $audios = DB::select('select * from audios left join resources using(resourceID) where audioID='.$id);
    foreach($audios as $audio){

        $audioFile.=$audio->url;

    }


    $covers = DB::select('select * from audios left join photos using(photoID) where photoID='.$id);
    foreach($covers as $cover){

        $imgFile=$cover->url;
        

    }



    //if(file_exists(public_path($imgFile))){

      //  unlink(public_path($imgFile));
  
      //}


      //if(file_exists(public_path($audioFile))){

      //  unlink(public_path($audioFile));
  
      //}

      DB::table('audios')->where('audioID', $id)->delete();
    return redirect()->back()->withSuccess('one audio deleted succesfuly.');
   
}


public function listen_audio($id)
    {
       
       //$audios= DB::table('audios')->where('audioID','!=', $id)->get(); 
       $audios = DB::select('select * from audios left join photos using(photoID) where audioID !='.$id);
       
        $lists = DB::select('select * from audios left join resources using(resourceID) where audioID='.$id);
        return view('pastor.listen_audio',['lists'=>$lists],['audios'=>$audios]);
    }
}
