<?php

namespace App\Http\Controllers;

use App\address;
use Illuminate\Http\Request;
use SermonsTable;
use DB;
use App\photos;
use App\Location;
use App\profile;
use App\churches;
use App\pastors;
use App\sermons;
use App\resources;
use App\audios;
use App\church_photos;
use App\church_services;
use App\events;
use App\eventphotos;
use App\reports;
use App\books;

class ManageController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index()
    {
        
       
       // $sermons= DB::table('sermons')->where('userID',7)->get(); 
        $sermonsb = DB::table('sermons')->get();
        $churches = DB::table('churches')->get();
        $users = DB::table('users')->get();
       
        return view('manage.index',['sermonsb'=>$sermonsb],['churches'=>$churches],['users'=>$users]);
    }


    public function add_photo($id)
    {
        $churches = DB::select('select * from churches where id='.$id);
        return view('manage.add_photo',['churches'=>$churches]);
    }

    public function add_premium()
    {
        
        return view('manage.add_premium_video');
    }

    public function video()
    {
        
        return view('manage.add_video');
    }

    public function book()
    {
        $books = DB::select('select * from books left join resources using(resourceID)');
        return view('manage.books',['books'=>$books]);
    }

    public function my_book()
    {
        $books = DB::select('select * from books left join resources using(resourceID) where userID='.auth()->user()->id);
        return view('manage.my_books',['books'=>$books]);
    }

    public function my_audios()
    {
        $audios = DB::select('select * from audios left join resources using(resourceID) where userID='.auth()->user()->id);
         return view('manage.my_audios',['audios'=>$audios]);
    }

    public function add_book()
    {
        return view('manage.add_book');
    }

    public function error()
    {
        
        return view('manage.errorpage');
    }

    public function download($file_name,$path) {
        $file_path = public_path($path.'/'.$file_name);
        return response()->download($file_path);
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
    


        return view('manage.photo_album',['churches'=>$churches],['photos'=>$photos]);
    }

    public function pastor_list($id)
    {
        $churches = DB::select('select * from churches where churchID='.$id);  
        $pastors= DB::select('select * from pastors where churchID='.$id);
       
        return view('manage.pastor_list',['churches'=>$churches],['pastors'=>$pastors]);
    }

    public function allvideo()
    {
        
        $videos = DB::select('select * from videos left join resources using (resourceID) where vidType="free" ');
        return view('manage.video_list',['videos'=>$videos]);
    }
    public function premiumvideo(){

        $videos = DB::select('select * from videos left join resources using(resourceID) where vidType="premium"');
        return view('manage.premium_videos',['videos'=>$videos]);

    }

    public function sermons()
    {

    $sermons = DB::select('select * from sermons order by sermonID DESC');
     
    return view('manage.sermons',['sermons'=>$sermons]);

    }

    public function my_church()
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
          return view('manage.my_church',['churches'=>$churches]);

    }

    public function my_sermons()
    {

    $sermons = DB::select('select * from sermons where userID='.auth()->user()->id.' order by sermonID DESC ');
     
    return view('manage.my_sermons',['sermons'=>$sermons]);

    }

    public function add_report($id){
       
        return view('manage.add_report',['church'=>$id]);
    }

    
public function church_report($id){
    $reports= DB::table('reports')
    ->select('resources.title','resources.url','resources.created_at','reports.reportMonth','reports.churchID','reports.id')
    ->join('resources','resources.resourceID','=','reports.resourceID')
    ->where(['churchID' => $id])
    ->get();
    return view('manage.church_report',['reports'=>$reports],['church'=>$id]);
}

    public function listen_audio($id)
    {
       
       //$audios= DB::table('audios')->where('audioID','!=', $id)->get(); 
       $audios = DB::select('select * from audios left join photos using(photoID) where audioID !='.$id);
       
        $lists = DB::select('select * from audios left join resources using(resourceID) where audioID='.$id);
        return view('manage.listen_audio',['lists'=>$lists],['audios'=>$audios]);
    }

    public function gallery($id)
    {
    $churches = DB::select('select * from churches where id='.$id);
    //$photos = DB::select('select * from church_photos where church_id='.$id.' order by id DESC');
    $photos= DB::table('church_photos')->where('church_id', $id)->paginate(6);
     
    return view('manage.photo_list',['photos'=>$photos],['churches'=>$churches]);

    }


    public function edit_photo($church_id,$photo_id)
    {
    $photos= DB::table('church_photos')->where('id', $photo_id)->get();  
    $churches= DB::table('churches')->where('id', $church_id)->get(); 
    return view('manage.edit_photo',['churches'=>$churches],['photos'=>$photos]);

    }

    public function update_photo($church_id,$photo_id)
    {
        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'caption'=>'required|string',
           // 'file' => 'required|mimes:jpeg,JPEG,png',
            ],
            [
                'title.required'=>'Enter a title for the photo you want to upload ',
                'caption.required'=>'Enter a caption for your photo  ',
               // 'file.required'=>'Please Upload a photo ',
                
                
                ]);

                if(count(request()->all()) > 0){

                    $file = request()->file('file');
                    $title = request()->input('title');
                    $caption= request()->input('caption');
                   


                    if(empty($file)){

                        DB::table('church_photos')->where('id', $photo_id)->update(['title' => $title, 'caption' => $caption]);
                    

                        return redirect()->back()->withSuccess('Update succesful.');
                    
                    }
                    else{ 
                        
                        ///// remove the existing file from folder /////////

                    $existFile=""; 
                    
                    $photos = DB::select('select * from church_photos where id='.$photo_id);
                    foreach($photos as $photo){
            
                        $existFile.=$photo->filename;
            
                    }

                    if(file_exists(public_path('churchPhoto/'.$existFile))){

                        unlink(public_path('churchPhoto/'.$existFile));
                  
                      }
                   
                  
                    //////// move file to upload folder ////////////////

            $original_name = strtolower(trim($file->getClientOriginalName()));
            $fileName =  time().rand(100,999).$original_name;
            $filePath = 'churchPhoto';
            $file->move($filePath,$fileName);
                

            //////////////// update database with new information ///////

            DB::table('church_photos')->where('id', $photo_id)
            ->update(['title' => $title, 'caption' => $caption,'filename' => $fileName]);
                     

           return redirect()->back()->withSuccess('Update succesful.');






                    }



                }





    }




    public function add_sermons()
    {
        return view('manage.add_sermon');
    }



    public function store_photo($id)
    {


                if(count(request()->all()) > 0){

                    ////// move file to upload folder ////////////////

                    $file = request()->file('file');
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $fileName =  time().rand(100,999).$original_name;
                    $filePath = 'churchPhoto';
                    $filePathdb=asset('/churchPhoto/'.$fileName);
                    $file->move($filePath,$fileName);
        
                    //////////// create data //////////////////////

                    $photos = new photos();
                    $photos->type= '2';
                    $photos->title= request()->input('title');
                    $photos->caption= request()->input('caption');
                    $photos->url=$filePathdb;

                   if( $photos->save() ){

                    $church_photos = new church_photos();
                    $church_photos->churchID= $id;
                    $church_photos->photoID=$photos->id;
                    $church_photos->userID= auth()->user()->id;
                    $church_photos->save();
                    
        
                   }
                   ////////// redirect to url //////////////////////////
        
                   return redirect()->back()->withSuccess('Photo uploaded succesfully');
                        
                    }else{
        
        
                         return redirect()->back()->withErrors($validator)->withInput();
        
                    }


       
    }


    public function eventPhoto($id,$id2)
    {


                if(count(request()->all()) > 0){

                    ////// move file to upload folder ////////////////

                    $file = request()->file('file');
                    $original_name = strtolower(trim($file->getClientOriginalName()));
                    $fileName =  time().rand(100,999).$original_name;
                    $filePath = 'eventPhoto';
                    $filePathdb=asset('/eventPhoto/'.$fileName);
                    $file->move($filePath,$fileName);
        
                    //////////// create data //////////////////////

                    $photos = new photos();
                    $photos->type= '8';
                    $photos->title= request()->input('title');
                    $photos->caption= request()->input('caption');
                    $photos->url=$filePathdb;

                   if( $photos->save() ){

                    $eventphotos = new eventphotos();
                    $eventphotos->churchID= $id;
                    $eventphotos->photoID=$photos->id;
                    $eventphotos->eventID=$id2;
                    $eventphotos->save();
                    
        
                   }
                   ////////// redirect to url //////////////////////////
        
                   return redirect()->back()->withSuccess('Photo uploaded succesfully');
                        
                    }else{
        
        
                         return redirect()->back()->withErrors($validator)->withInput();
        
                    }


       
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
            $filePathdb=asset('/upload/'.$fileName);
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



    public function store_report($id)
    {
        //1.validate data
        
        $validator=$this->validate(request(),[
        'topic'=>'required|string',
        'date'=>'required|string',
        'file' => 'required|mimes:pdf,docx,doc',
        ],
        [
            'topic.required'=>'Type in Title of the report you want to Upload ',
            'date.required'=>'Choose date ',
            'file.required'=>'Please Upload a PDF/doc file ',
            
            
            ]);

            if(count(request()->all()) > 0){

            ////// move file to upload folder ////////////////

            $file = request()->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = 'report';
            $filePathdb=asset('/report/'.$fileName);
            $file->move($filePath,$fileName);
            $user = auth()->user()->id;

            //////////// create data //////////////////////

           

           

            $resource = new resources;

            $resource->title = request()->input('topic');
            $resource->type = 9;
            
            $resource->note ='report';
            $resource->url =$filePathdb;
            $resource->isPublic= 0;
            $resource->uploadby=auth()->user()->name;
            $resource->artist = auth()->user()->name;;
           
                   if($resource->save()){ 
                       
                    $reports = new reports;
                    $reports->churchID = $id;
                    $reports->reportMonth = request()->input('date');
                    $reports->resourceID = $resource->id;
                    $reports->userID =auth()->user()->id;
                    $reports->save();

                       

                    }     
                
           


           ////////// redirect to url //////////////////////////

           return redirect()->back()->withSuccess('Report uploaded succesfully !');
                
            }else{


                 return redirect()->back()->withErrors($validator)->withInput();

            }
                ///// move uploaded file to folder


           

            
        //2. create data

        //3. redirect url

            
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
            $churches->id= auth()->user()->id;
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



public function update_user($id){

     //1.validate data
        
     $validator=$this->validate(request(),[
        'firstname'=>'required|string',
        'lastname'=>'required|string',
        'phone'=>'required|string',
        'town'=>'required|string',
        'state'=>'required|string',
        'country'=>'required|string',
        'role'=>'required|string',
        
        
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
             DB::table('users')->where('id', $id)->update(['role' => request()->input('role')]);
                 
                
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


    public function store_users()
    {
        //1.validate data
        
        $validator=$this->validate(request(),[
        'name'=>'required|string',
        'email' =>'required|string|email|max:255|unique:users',
        'password'=>'required|string',
        'role'=>'required|string',
        
        ],
        [
            'name.required'=>'Type in the name of user you are creating account for ',
            'password.required'=>'Enter Password',
            'role.required'=>'Choose a role for user ',
            
            
            ]);

            if(count(request()->all()) > 0){

            $user = auth()->user()->id;

            //////////// create data //////////////////////

            $name = request()->input('name');
            $email= request()->input('email');
            $password = $this->encrypt_decrypt(request()->input('password'),true);
            $api_token = mt_rand(1000000000, 9999999999);
            $role = request()->input('role');
            $created= date('Y-m-d H:i:s');
            
            
            $data=array('name'=>$name,"email"=>$email,"password"=>$password,"api_token"=>$api_token,"role"=>$role,"created_at"=>$created);
            DB::table('users')->insert($data);


           ////////// redirect to url //////////////////////////

           return redirect()->back()->withSuccess('User account created succesfuly !');
                
            }else{


                 return redirect()->back()->withErrors($validator)->withInput();

            }
              

            
    }


public function usersettings($id){

    $churches = DB::select('select * from churches where churchID='.$id);
    return view('manage.user_settings',['churches'=>$churches]);
}

public function add_pastor($id){

    $validator=$this->validate(request(),[
        'email'=>'required|string',
        'right'=>'required|string',
        
        ],
        [
            'email.required'=>'Please enter pastor email ',
            'right.required'=>'Endeavour to check the right you want to assign to pastor ',
           
            
            ]);

            if(count(request()->all()) > 0){

               $user="";
                $users= DB::table('users')->where('email', request()->input('email'))->get();
               if($users->count()<1){

                return redirect()->back()->withErrors('This user does not exist. "'.request()->input('email').'"');
             
               }else{
                 foreach($users as $user){
                    if($user->role=='user'){

                    return redirect()->back()->withErrors('this user is not yet confirmed. User account should be confirmed before access right can be given.');
             
                    }else{

                        $user=$user->id;

                        $pastors = new pastors();
                        $pastors->userID = $user;
                        $pastors->churchID = $id;
                        $pastors->pastorRight= request()->input('right');
                        if($pastors->save()){

                            return redirect()->back()->withSuccess('Pastor added succesfuly');
                        }


                    }

                 }  
                }
                    
    
            }

}

    public function churches()
    {

        $churches = DB::select('select * from churches order by churchID DESC');
        return view('manage.churches',['churches'=>$churches]);

    }

    public function add_church()
    {
        return view('manage.add_church');
    }



    public function users()
    {
        $users = DB::select('select * from profile LEFT JOIN users using(id) order by id DESC');
        return view('manage.users',['users'=>$users]);
    }


    public function edit_users($id)
    {

   

        $users = DB::select('select * from profile LEFT JOIN users USING(id) LEFT JOIN photos USING(photoID) LEFT JOIN address USING(addressID) where id='.$id);
        return view('manage.edit_user',['users'=>$users]);
        
                
    }




    public function add_user()
    {
        return view('manage.add_user');
    }




    public function audios()
    {
       $audios = DB::select('select * from audios left join resources using(resourceID) ');
       // $audios= DB::table('audios')->get();
      
        return view('manage.audios',['audios'=>$audios]);
    }

    public function add_audio()
    {
        return view('manage.add_audio');
    }


    public function show($id)
    
    {
        $sermons = DB::select('select * from sermons LEFT JOIN resources USING (resourceID) where sermonID='.$id);
     
    return view('manage.view',['sermons'=>$sermons]);
       
    }

    public static function showUsername($id){
        $fullname="";
        $names = DB::select('select * from users where id='.$id);
        foreach($names as $name){

        $fullname.=ucwords($name->name);

        }
       return $fullname;

    }



    public function showChurch($id)
    
    {
        $churches = DB::select('select * from churches left join address using(addressID) where churchID='.$id);
        $photos = DB::select('select * from church_photos left join photos using(photoID) where churchID='.$id);
        
       
        
        
    return view('manage.view_church',['churches'=>$churches],['photos'=>$photos]);
       
    }


    public static function showServices($id){

    $services= DB::table('church_services')->where('churchID', $id)->paginate(4); 
    return $services;

    }




    public function edit($id)
    
    {
        $sermons = DB::select('select * from sermonS left join resources using(resourceID) where sermonID='.$id);
     
    return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function churchEdit($id)
    
    {
        $churches = DB::select('select * from churches LEFT JOIN address USING(addressID) where churchID='.$id);
     
     
    return view('manage.edit_church',['churches'=>$churches]);
       
    }


    public function destroy($id)
    
    {
        $resid="";
        $url="";
        
        
        $sds = DB::select('select * from sermons where sermonID='.$id);
        foreach($sds as $sd){

            $resid=$sd->resourceID;   
        }

        $res = DB::select('select * from resources where resourceID='.$resid.'');
        foreach($res as $re){

            $url=$re->url;   
        }


        if(file_exists(public_path($url))){

            unlink(public_path($url));
      
          }

        $sermons = DB::delete('delete from sermons where sermonID='.$id);
        $resources = DB::delete('delete from resources where resourceID='.$resid);
        return redirect()->back()->withSuccess('one record deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function destroyChurch($id)
    
    {
        $sermons = DB::delete('delete from churches where churchID='.$id);
        $pastors = DB::delete('delete from pastors where churchID='.$id);
        return redirect()->back()->withSuccess('one record deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }

    public function view_book($id){

     $books= DB::table('books')
     ->select('resources.title','resources.note','resources.artist','resources.uploadby','books.id','books.status','books.bookType')    
     ->join('photos','photos.photoID','=','books.photoID')
    ->join('resources','resources.resourceID','=','books.resourceID')
    ->where('id', $id)
    ->get();

          return view('manage.view_book',['books'=>$books]);
    }

    public function pastor_delete($id)
    
    {
        $sermons = DB::delete('delete from pastors where pastorID='.$id);
        return redirect()->back()->withSuccess('pastor deleted succesfuly.');

       
    }


    public function delete_photo($id)
    
    {
        $existFile=""; 
        $photos = photos::where('photoID', '=', $id)->first();
        $existFile.= $photos->url;
            
                    

                    if(file_exists(public_path($existFile))){

                        unlink(public_path($existFile));
                  
                      }

        DB::table('church_photos')->where('photoID', $id)->delete();
        DB::table('photos')->where('photoID', $id)->delete();
        return redirect()->back()->withSuccess('one photo deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function events($id){
        
        $churches = DB::select('select * from churches where churchID='.$id);
        $events= DB::table('events')->where('churchID', $id)->paginate();
        
        return view('manage.events',['events'=>$events],['churches'=>$churches]);

    }


    public function store_events($id)
    {


                if(count(request()->all()) > 0){

                    ////// move file to upload folder ////////////////

                  //  $file = request()->file('file');
                  //  $original_name = strtolower(trim($file->getClientOriginalName()));
                  //  $fileName =  time().rand(100,999).$original_name;
                  //  $filePath = 'eventPhoto';
                  //  $filePathdb='/eventPhoto/'.$fileName;
                  //  $file->move($filePath,$fileName);
        
                    //////////// create data //////////////////////

                   $address = new Location();
                   $address->town= request()->input('town');
                   $address->country= request()->input('country');
                   $address->state= request()->input('state');
                   $address->lat="";
                   $address->lng= "";
                   if( $address->save()){

                    $events= new events();
                    $events->churchID= $id;
                    $events->title= request()->input('title');
                    $events->note= request()->input('note');
                    $events->author= auth()->user()->name;
                    $events->startTime=request()->input('startTime');
                    $events->endTime=request()->input('endTime');
                    $events->addressID=$address->id;
                    $events->save();
                   ////////// redirect to url //////////////////////////
        
                   return redirect()->back()->withSuccess('Events uploaded succesfully');
                   }    
                    }


       
    }

    public function delete_events($id)
    
    {
        //$existFile=""; 
        //$photos = photos::where('photoID', '=', $id)->first();
       // $existFile.= $photos->url;
            
                    

                  //  if(file_exists(public_path($existFile))){

                     //   unlink(public_path($existFile));
                  
                    //  }

        DB::table('events')->where('eventID', $id)->delete();
       // DB::table('photos')->where('photoID', $id)->delete();
        return redirect()->back()->withSuccess('one event deleted succesfuly.');
       
    }

    public function delete_report($id)
    
    {
        $existFile=""; 

        $report= DB::table('reports')
    ->select('resources.url','resources.resourceID')
    ->join('resources','resources.resourceID','=','reports.resourceID')
    ->where(['id' => $id])
    ->first();

    $existFile=$report->url;
      
                if(file_exists(public_path('/report/'.basename($existFile)))){

                      unlink(public_path('/report/'.basename($existFile)));
                  
                     }

        DB::table('resources')->where('resourceID', $report->resourceID)->delete();
        DB::table('reports')->where('id', $id)->delete();
       
        return redirect()->back()->withSuccess('report deleted succesfuly.');
       
    }


    public function delete_book($id)
    
    {
        $existFile=""; 
        $existFile2=""; 

        $books= DB::table('books')
    ->select('resources.url','resources.resourceID','books.photoID')
    ->join('resources','resources.resourceID','=','books.resourceID')
    ->where(['id' => $id])
    ->first();

    $existFile=$books->url;
    
      
                if(file_exists(public_path('/books/'.basename($existFile)))){

                      unlink(public_path('/books/'.basename($existFile)));
                  
                   }


  $books2= DB::table('books')
                   ->select('photos.url','photos.photoID')
                   ->join('photos','photos.photoID','=','books.photoID')
                   ->where(['id' => $id])
                   ->first();

                   $existFile2=$books2->url;
    
      
                   if(file_exists(public_path('/photos/'.basename($existFile2)))){
   
                         unlink(public_path('/photos/'.basename($existFile2)));
                     
                      }

       DB::table('resources')->where('resourceID', $books->resourceID)->delete();
        DB::table('photos')->where('photoID', $books->photoID)->delete();
        DB::table('books')->where('id', $id)->delete();
       
       return redirect()->back()->withSuccess('book deleted succesfuly.');
       
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
       
       

        return view('manage.event_detail',['event'=>$event],['churches'=>$churches]);
       
    }


    public function view_events($id){
        $church = events::where('photoID', '=', $id)->first();
        $churches = DB::select('select * from churches where churchID='.$church->churchID);
     
        

        $events = DB::select('select * from events left join photos using(photoID) where churchID='.$church->churchID);
        return view('manage.view_events',['events'=>$events],['churches'=>$churches]);

    }


    public function photodetail($id){
        $cp = church_photos::where('photoID', '=', $id)->first();
        $churches = DB::select('select * from churches where churchID='.$cp->churchID);
     
        

        $photos = photos::where('photoID', '=', $id)->first();
        return view('manage.view_photo_detail',['photos'=>$photos],['churches'=>$churches]);

    }

    public function event_photo_detail($id,$id2,$id3){

        $event = DB::table('eventphotos')

    ->select('photos.title','photos.caption','photos.url','photos.url','photos.created_at')
    
    ->join('photos','photos.photoID','=','eventphotos.photoID')
    
    ->where(['id' => $id3])
    
    ->first();
       
    $churches = DB::select('select * from churches where churchID='.$id);
        return view('manage.event_photo_detail',['event'=>$event],['churches'=>$churches]);


    }

    
    public function showChurchservices($id){


        $churches = DB::select('select * from churches where churchID='.$id);
        //$services = church_services::where('churchID', '=', $id)->first();
        $services = DB::table('church_services')->where('churchID', $id)->get();

        return view('manage.view_church_service',['services'=>$services],['churches'=>$churches]);


    }

    public function serviceSermonx($id,$id2){
       
        $sermonid="";
        $churchServices=DB::table('church_services')->where('serviceID', $id2)->get();
        foreach($churchServices as $churchService){
        $sermonid=$churchService->sermonID;
        }
        $sermons = DB::select('select * from sermons left join resources using(resourceID) where sermonID='.$sermonid);
        $churches = DB::select('select * from churches where churchID='.$id);
       
        return view('manage.service_sermon',['sermons'=>$sermons],['churches'=>$churches]);
    
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


    public function delete_users($id)
    
    {
        

        DB::table('users')->where('id', $id)->delete();
        DB::table('profile')->where('id', $id)->delete();
        return redirect()->back()->withSuccess('one user deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
    }


    public function delete_audio($id)
    
{
    
   


    $imgFile="";
    $audioFile=""; 
    $photoid="";
        
    $audios = DB::select('select * from audios left join resources using(resourceID) where audioID='.$id);
    foreach($audios as $audio){

        $audioFile=$audio->url;
        $photoid=$audio->photoID;

    }


    $covers = DB::select('select * from  photos where photoID='.$photoid);
    foreach($covers as $cover){

        $imgFile=$cover->url;
        
        

    }



    if(file_exists(public_path($imgFile))){

        unlink(public_path($imgFile));
  
      }


      if(file_exists(public_path($audioFile))){

        unlink(public_path($audioFile));
  
      }

      DB::table('audios')->where('audioID', $id)->delete();
    return redirect()->back()->withSuccess('one audio deleted succesfuly.');
   
}

    public function delete_service($id)
    
    {
        

        DB::table('church_services')->where('serviceID', $id)->delete();
        return redirect()->back()->withSuccess('service deleted succesfuly.');
   // return view('manage.edit_sermon',['sermons'=>$sermons]);
       
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
            $filePathdb = asset('/upload/'.$fileName);
            $file->move($filePath,$fileName);
                
            $sermon2= request()->input('sermon');
            //////////////// update database with new information ///////

           DB::table('resources')->where('resourceID', $resid)->update(['title'=>$topic, 'artist' => $author,'note' =>$sermon2,'url'=> $filePathdb]);
                              
            

           return redirect()->back()->withSuccess('Update succesful.');






                    }



                }
       
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
        $church_services->save();


       return redirect()->back()->withSuccess('Update succesful.');


          

}  


    public function edit_event_post($id,$id2)
    
    {
             if(count(request()->all()) > 0){

                   
                    $title = request()->input('title');
                    $starttime= request()->input('starttime');
                    $endtime= request()->input('endtime');
                    $country = request()->input('country');
                    $state= request()->input('state');
                    $town= request()->input('town');
                    $note= request()->input('note');


                        
                    $pullchurchs = DB::select('select * from events where eventID='.$id2);
                    foreach($pullchurchs as $pullchurch){

                        DB::table('address')->where('addressID', $pullchurch->addressID)->update(['country' =>request()->input('country'), 'state' => request()->input('state'),'town' => request()->input('town')]);
                    

                    }

                    DB::table('events')->where('eventID', $id2)->update(['title' => $title, 'startTime' => $starttime,'endTime' => $endtime,'note' => $note]);
                   
                    //$churches = DB::select('select * from churches where churchID='.$id);
                    return redirect()->back()->withSuccess('Update succesful.');
                    
                  
                   



                }
       
    }


    public function churchUpdate($id)
    
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
                'title.required'=>'Enter audio title ',
                'artist.required'=>'Enter artist name ',
                'note.required'=>'Enter a note for audio ',
                'imgfile.required'=>'Upload photo for audio',
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
            $filePathdb = asset('/photos/'.$fileName);
            $imgfile->move($filePath,$fileName);

             //////// move audiofile to audios folder ////////////////

             $original_audioname = strtolower(trim($audiofile->getClientOriginalName()));
             $fileName2 =  time().rand(100,999).$original_audioname;
             $filePath2 = 'audios';
             $filePath2db = asset('/audios/'.$fileName2);
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



public function store_book()    
{
    $validator=$this->validate(request(),[
        'title'=>'required|string',
        'author'=>'required|string',
        'note'=>'required|string',
        'type'=>'required|string',
        'imgfile'=>'required|mimes:jpeg,JPEG,png',
        'file' => 'required|mimes:pdf,docx,doc',
       
        
        
        ],
        [
            'title.required'=>'Enter audio title ',
            'artist.required'=>'Enter artist name ',
            'note.required'=>'Enter a note for audio ',
            'imgfile.required'=>'Upload book cover',
            'file.required'=>'Upload an PDF file of book',
            
            
            ]);

            if(count(request()->all()) > 0){

               
                $resourceid="";
                $imgfile= request()->file('imgfile');
                $audiofile= request()->file('file');

            

                  //////// move imgfile to photos folder ////////////////

        $original_filename = strtolower(trim($imgfile->getClientOriginalName()));
        $fileName =  time().rand(100,999).$original_filename;
        $filePath = 'photos';
        $filePathdb = asset('/photos/'.$fileName);
        $imgfile->move($filePath,$fileName);

         //////// move file to books folder ////////////////

         $original_audioname = strtolower(trim($audiofile->getClientOriginalName()));
         $fileName2 =  time().rand(100,999).$original_audioname;
         $filePath2 = 'books';
         $filePath2db = asset('/books/'.$fileName2);
         $audiofile->move($filePath2,$fileName2);


         $resource = new resources;

         $resource->title = request()->input('title');
         $resource->type = 3;
         
         $resource->note = request()->input('note');
         $resource->url =$filePath2db;
         $resource->isPublic= 0;
         $resource->uploadby=auth()->user()->name;
         $resource->artist = request()->input('author');
         if($resource->save()){
            $resourceid=$resource->id;

            $photos = new photos();

                    $photos->type= '5';
                    $photos->title= request()->input('title');
                    $photos->caption=request()->input('note');
                    $photos->url=$filePathdb;
                   if($photos->save()){



                    $books = new books;

                   
                    $books->userID=auth()->user()->id;
                    $books->bookType=request()->input('type');
                    $books->resourceID= $resourceid;
                    $books->status=0;
                    $books->photoID=$photos->id;
                    $books->save();
 

            return redirect()->back()->withSuccess('Book upload succesful.');


         }
                
              
               



            }
   
}

}



    public function store_premium_videos()    
    {
        $validator=$this->validate(request(),[
            'title'=>'required|string',
            'author'=>'required|string',
            'note'=>'required|string',
            'imgfile'=>'required|mimes:jpeg,JPEG,png',
            'videofile'=>'required|file:mp4',
           
            
            
            ],
            [
                'title.required'=>'Enter video title ',
                'author.required'=>'Enter author name ',
                'note.required'=>'Enter a note for audio ',
                'imgfile.required'=>'Upload photo for audio',
                'videofile.required'=>'Upload a video',
                
                
                ]);

                if(count(request()->all()) > 0){

                   
                    $title = request()->input('title');
                    $author = request()->input('author');
                    $note= request()->input('note');
                    $imgfile= request()->file('imgfile');
                    $videofile= request()->file('videofile');
                    $created= date('Y-m-d H:i:s');

                     //////// move imgfile to photos folder ////////////////

            $original_filename = strtolower(trim($imgfile->getClientOriginalName()));
            $fileNamea =  time().rand(100,999).$original_filename;
            $filePatha = 'photos';
            $filePathdba = asset('/photos/'.$fileNamea);
            $imgfile->move($filePatha,$fileNamea);



             //////// move videofile to audios folder ////////////////

             $original_videoname = strtolower(trim($videofile->getClientOriginalName()));
             $fileName =  time().rand(100,999).$original_videoname;
             $filePath = 'premiumVideos';
             $filePathdb = asset('/premiumVideos/'.$fileName);
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


                $resourceid=$resource->id;

                $photos = new photos();

                        $photos->type= '4';
                        $photos->title= request()->input('title');
                        $photos->caption= "cover photo";
                        $photos->url=$filePathdba;
                       if($photos->save()){


             $data=array('resourceID'=>$resource->id,'vidType'=>"premium","userID"=>auth()->user()->id,'photoID'=>$photos->id,"status"=>'0',"created_at"=>$created);
             DB::table('videos')->insert($data);
     

                return redirect()->back()->withSuccess('upload succesful.');
                       }
                    
             }    
                   



                }
       
    }

    public function allow_user(Request $request){

        switch ($request->input('action')) {
            case 'activate':
                
    
                if(isset($_POST['user'])){
                    if (is_array($_POST['user'])) {
                         foreach($_POST['user'] as $value){
                            DB::table('users')->where('id', $value)->update(['role' => 'manage-sub']);
                         }
    
                         return redirect()->back()->withSuccess('user set to active mode sucessfuly.');
    
                      } else {
                        $value = $_POST['user'];
                        DB::table('users')->where('id', $value)->update(['role' => 'manage-sub']);
                        return redirect()->back()->withSuccess('user set to active mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one user to activate');
               }
    
                       
    
    
                break;
    
            case 'deactivate':
                
                if(isset($_POST['user'])){
                    if (is_array($_POST['user'])) {
                         foreach($_POST['user'] as $value){
                            DB::table('users')->where('id', $value)->update(['role' => 'user']);
                         }
    
                         return redirect()->back()->withSuccess('user set to inactive mode sucessfuly.');
    
                      } else {
                        $value = $_POST['user'];
                        DB::table('users')->where('id', $value)->update(['role' => 'user']);
                        return redirect()->back()->withSuccess('User set to inactive mode sucessfuly.');
                   }
               }else{
    
    
                return redirect()->back()->withErrors('Please check atleast one user to deactivate');
               }
    
    
                break;
    
            
        }

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


public function audioMultipleDelete(Request $request){

    switch ($request->input('action')) {
        case 'deleteall':

    if(isset($_POST['audio'])){



        if (is_array($_POST['audio'])) {
             foreach($_POST['audio'] as $value){

                $imgFile="";
                $audioFile=""; 
                    
                $audios = DB::select('select * from audios where id='.$value);
                foreach($audios as $audio){
        
                    $imgFile.=$audio->imgname;
                    $audioFile.=$audio->audioname;
        
                }

                if(file_exists(public_path('photos/'.$imgFile))){

                    unlink(public_path('photos/'.$imgFile));
              
                  }


                  if(file_exists(public_path('audios/'.$audioFile))){

                    unlink(public_path('audios/'.$audioFile));
              
                  }


                $audios = DB::delete('delete from audios where id='.$value);
             }

             return redirect()->back()->withSuccess('Audio deleted sucessfuly.');

          } else {
            $value = $_POST['audio'];
            $audios = DB::delete('delete from audios where id='.$value);
            return redirect()->back()->withSuccess('Audio deleted sucessfuly.');
       }
   }else{


    return redirect()->back()->withErrors('Please check atleast one audio to delete');
   }

break;
    }
}
     //1.validate data
        
    public function searchquery(Request $request){
        $searchterm = $request->input('search-term');
        
        $searchresults = DB::table('sermons')->where('topic', 'like', $searchterm.'%')->get();

        return view('manage.search',['sermons'=>$searchresults]);



    }

  public static function showtopics(){
    $messagesb = DB::select('select * from sermons left join resources using(resourceID) ');
    
    return $messagesb;

  } 


  public function serviceSermons($id)
  {
      //1.validate data

          if(count(request()->all()) > 0){

          ////// move file to upload folder ////////////////

          $file = request()->file('file');
          $fileName = $file->getClientOriginalName();
          $filePath = 'upload';
          $filePathdb=asset('/upload/'.$fileName);
          $file->move($filePath,$fileName);
          $user = auth()->user()->id;

          //////////// create data //////////////////////

          $resource = new resources;

                      $resource->title = request()->input('topic');
                      $resource->type = 4;
                      
                      $resource->note = request()->input('sermon');
                      $resource->url =$filePathdb;
                      $resource->isPublic= 0;
                      $resource->uploadby=auth()->user()->name;
                      $resource->artist = request()->input('author');
                     if($resource->save()){



                    $sermons = new sermons;

                  $sermons->topic = request()->input('topic');
                  $sermons->author = request()->input('author');
                  $sermons->userID = auth()->user()->id;
                  $sermons->resourceID = $resource->id;
                  $sermons->status =0;
                  $sermons->postedBy = auth()->user()->name;
                  if($sermons->save()){

                      DB::table('church_services')->where('serviceID', request()->input('serviceid'))->update(['sermonID'=>$sermons->id]);
     

                  }    

                     }

          
              
         


         ////////// redirect to url //////////////////////////

         return redirect()->back()->withSuccess('Sermon uploaded succesfully !');
              


          
  }
}



public function serviceSermonView($id){



}
  
  public function add_video()
  {

      $validator=$this->validate(request(),[
          'title'=>'required|string',
          'artist'=>'required|string',
          'note' => 'required|string',
          'id' => 'required|string',
          'file'=>'required|mimes:jpeg,JPEG,png',
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


 ////// move file to upload folder ////////////////

 $file = request()->file('file');
 $original_name = strtolower(trim($file->getClientOriginalName()));
 $fileName =  time().rand(100,999).$original_name;
 $filePath = 'photos';
 $filePathdb=asset('/photos/'.$fileName);
 $file->move($filePath,$fileName);



                $resource = new resources;

                        $resource->title = request()->input('title');
                        $resource->type = 1;
                        
                        $resource->note = request()->input('note');
                        $resource->url =request()->input('id');
                        $resource->isPublic= 0;
                        $resource->uploadby=auth()->user()->name;
                        $resource->artist = request()->input('artist');
                        if($resource->save()){

                            $photos = new photos();

                            $photos->type= '4';
                            $photos->title= request()->input('title');
                            $photos->caption= "cover photo";
                            $photos->url=$filePathdb;
                           if($photos->save()){

                $data=array('resourceID'=>$resource->id,'vidType'=>"free","userID"=>auth()->user()->id,"photoID"=>$photos->id,"status"=>'0');
                DB::table('videos')->insert($data);
                return redirect()->back()->withSuccess('Upload sucessful.');
                           }     
            
            }
               

              }}

 public static function allVideos(){

                
                $videos= DB::table('videos')->get(); 
    
                return $videos;

              }


public static function allAudios(){

    $audios= DB::table('audios')->get(); 
    
    return $audios;
    
           

              }


              public static function showCountries(){

                $countries= DB::table('countries')->get(); 
                
                return $countries;
                
                       
            
                          }



     public static function encrypt_decrypt ($data, $encrypt) {
                            if ($encrypt == true) {
                                $output = base64_encode (convert_uuencode ($data));
                            } else {
                                $output = convert_uudecode (base64_decode ($data));
                            }
                            return $output;
                            
                            
                            
                        }

    public function profile($id){

        $users = DB::select('select * from profile LEFT JOIN users USING(id) LEFT JOIN photos USING(photoID) LEFT JOIN address USING(addressID) where id='.$id);
       
        return view('manage.profile_view',['users'=>$users]);  

    }


    
    public static function showAudiotitle($id){
        $resourcetitle="";
    
        $resources = DB::select('select * from  resources where resourceID ='.$id);
        foreach($resources as $resource){
    
          
               $resourcetitle=$resource->artist;
    
           }
          
    
    
    return $resourcetitle;
    }

    public function delete_event_photo($id,$id2,$id3){
        $File="";

        $photos = DB::select('select * from photos where photoID='.$id3);
        foreach($photos as $photo){

            $File=basename($photo->url);
        

        }

        if(file_exists(public_path('/eventPhoto/'.$File))){

            unlink(public_path('/eventPhoto/'.$File));
      
          }

         


        DB::table('eventphotos')
        ->where('photoID', $id3)
        ->delete();

        DB::table('photos')
        ->where('photoID', $id3)
        ->delete();

        return redirect()->back()->withSuccess('event photo deleted succesfuly.');

    }


    public function edit_event($id,$id2){


      $churches= DB::table('churches')->where('churchID', $id)->get();


      $event= DB::table('events')
      ->select('events.eventID','events.title','events.note','events.author','events.startTime','events.endTime','address.country','address.state','address.town')
      ->join('address','address.addressID','=','events.addressID') 
      ->where(['eventID' => $id2])
        ->first();
     
      return view('manage.edit_event',['event'=>$event],['churches'=>$churches]);
            
    }


 public static function showChurchPhotos($id){
$photoList=array();
$churches= DB::table('church_photos')
->select('photos.url')
->join('photos','photos.photoID','=','church_photos.photoID') 
->where(['churchID' => $id])
->paginate();

   foreach($churches as $church){
    array_push($photoList,$church->url);
   }
 return $photoList;
 }   

 public static function showEventPhotos($id){
    $photoList=array();
    $pbind=array();
    $eventphotos= DB::table('eventphotos')
    ->select('photos.url','photos.title','photos.caption')
    ->join('photos','photos.photoID','=','eventphotos.photoID') 
    ->where(['eventID' => $id])
    ->paginate();
    
       foreach($eventphotos as $eventphoto){
        $pbind['url']=$eventphoto->url;
        $pbind['title']=$eventphoto->title;
        $pbind['caption']=$eventphoto->caption;
        array_push($photoList,$pbind);
       }
     return $photoList;
     }   

     public static function showEventPhotospage($id,$id2){
         if($id2=='all'){

            $photoList=array();
            $pbind=array();
            $eventphotos= DB::table('eventphotos')
            ->select('photos.url','photos.title','photos.caption')
            ->join('photos','photos.photoID','=','eventphotos.photoID') 
            ->where(['eventID' => $id])
            ->get();
            
               foreach($eventphotos as $eventphoto){
                $pbind['url']=$eventphoto->url;
                $pbind['title']=$eventphoto->title;
                $pbind['caption']=$eventphoto->caption;
                array_push($photoList,$pbind);
               }
             return $photoList;

         }else{
        $photoList=array();
        $pbind=array();
        $eventphotos= DB::table('eventphotos')
        ->select('photos.url','photos.title','photos.caption')
        ->join('photos','photos.photoID','=','eventphotos.photoID') 
        ->where(['eventID' => $id])
        ->paginate($id2);
        
           foreach($eventphotos as $eventphoto){
            $pbind['url']=$eventphoto->url;
            $pbind['title']=$eventphoto->title;
            $pbind['caption']=$eventphoto->caption;
            array_push($photoList,$pbind);
           }
         return $photoList;
        }
         }   


 public static function showChurchPhotosPag($id,$page){
    $photoList=array();
    $churches= DB::table('church_photos')
    ->select('photos.url')
    ->join('photos','photos.photoID','=','church_photos.photoID') 
    ->where(['churchID' => $id])
    ->paginate($page);
    
       foreach($churches as $church){
        array_push($photoList,$church->url);
       }
     return $photoList;
     }   



     public static function showServicesPaging($id,$page){
        $photoList=array();
        $pbind=array();
        $churches= DB::table('church_services')->where('churchID', $id)
        ->where(['churchID' => $id])
        ->paginate($page);
        
           foreach($churches as $church){

            $pbind['title']=$church->title;
            $pbind['month']=$church->month;
            
            $pbind['time']=$church->time;
            if($church->sermonID!=''){
            //$pbind['sermon']=ManageController::showsermonUrl($church->sermonID);
            $pbind['sermonID']=$church->sermonID;
            }else{

                $pbind['sermonID']=$church->sermonID;

            }
            array_push($photoList,$pbind);
           }
         return $photoList;
         }  
         
         
         public static function showsermonUrl($val){

            if(!empty($val)){
            $sermon= DB::table('sermons')
            ->select('resources.url')
            ->join('resources','resources.resourceID','=','sermons.resourceID') 
            ->where(['sermonID' => $val])
            ->where(['status' =>1])
             ->first();

            return $sermon->url;

            }else{
                return '';

            }
         }

 public static function ChurchServices($id){
    $photoList=array();
    $churches= DB::table('church')
    ->select('photos.url')
    ->join('photos','photos.photoID','=','church_photos.photoID') 
    ->where(['churchID' => $id])
    ->get();
    
       foreach($churches as $church){
        array_push($photoList,$church->url);
       }
     return $photoList;
     }   

     public static function pastorAudios($id){
        $audioList=array();
        $audios= DB::table('audios')
        ->select('audios.audioID','audios.audioType','photos.title','photos.photoID','photos.created_at')
        ->join('photos','photos.photoID','=','audios.photoID') 
        ->where(['userID' => $id])
        ->get();
        
           foreach($audios as $audio){
            array_push($audioList,$audio->title);
           }
         return $audioList;
         }  
         
         
         public static function pastorAudiospaging($id,$id2){
            $audioList=array();
            $audios= DB::table('audios')
            ->select('audios.audioID','audios.audioType','photos.title','photos.photoID','photos.created_at')
            ->join('photos','photos.photoID','=','audios.photoID') 
            ->where(['userID' => $id])
            ->paginate($id2);
            
               foreach($audios as $audio){
                array_push($audioList,$audio->title);
               }
             return $audioList;
             }  

         public static function pastorVideos($id){
            $audioList=array();
            $audios= DB::table('videos')
            ->select('videos.videoID','videos.vidType','photos.title','photos.photoID','photos.created_at')
            ->join('photos','photos.photoID','=','videos.photoID') 
            ->where(['userID' => $id])
            ->get();
            
               foreach($audios as $audio){
                array_push($audioList,$audio->title);
               }
             return $audioList;
             } 


             
             
             public static function pastorVideospaging($id,$id2){
                $audioList=array();
                $audios= DB::table('videos')
                ->select('videos.videoID','videos.vidType','photos.title','photos.photoID','photos.created_at')
                ->join('photos','photos.photoID','=','videos.photoID') 
                ->where(['userID' => $id])
                ->paginate($id2);
                
                   foreach($audios as $audio){
                    array_push($audioList,$audio->title);
                   }
                 return $audioList;
                 } 

                 public static function pastorSermons($id){
                    $sermonList=array();
                    $sermons= DB::table('sermons')
                    ->select('sermons.sermonID','sermons.topic','sermons.created_at','resources.url')
                    ->join('resources','resources.resourceID','=','sermons.resourceID') 
                    ->where(['userID' => $id])
                    ->get();
                    
                       foreach($sermons as $sermon){
                        array_push($sermonList,$sermon->topic);
                       }
                     return $sermonList;
                     }   
             public static function pastorSermonspaging($id,$id2){
                $sermonList=array();
                $sermons= DB::table('sermons')
                ->select('sermons.sermonID','sermons.topic','sermons.created_at','resources.url')
                ->join('resources','resources.resourceID','=','sermons.resourceID') 
                ->where(['userID' => $id])
                ->paginate($id2);
                
                   foreach($sermons as $sermon){
                    array_push($sermonList,$sermon->topic);
                   }
                 return $sermonList;
                 }   

                 public static function audiosFile($id){

                    $audiofile= DB::table('audios')
                    ->select('resources.url')
                    ->join('resources','resources.resourceID','=','audios.resourceID') 
                    ->where(['audioID' => $id])
                    ->first();
                    return $audiofile->url;
                 }

                 public static function videoUrl($id){

                    $videofile= DB::table('videos')
                    ->select('resources.url')
                    ->join('resources','resources.resourceID','=','videos.resourceID') 
                    ->where(['videoID' => $id])
                    ->first();
                    return $videofile->url;
                 }

         public static function   pullEventPhotos($id){

            $photos = DB::table('eventphotos')

            ->select('photos.photoID','photos.title','photos.caption','photos.url','eventphotos.id')
            
            ->join('photos','photos.photoID','=','eventphotos.photoID')
            
            ->where(['eventID' => $id])
            
            ->paginate(9);

            return $photos;


                 }

        public static function getpastorpix($id){
            $pix="";
            $profiles = DB::select('select * from  profile left join photos using (photoID) where id='.$id);
            foreach($profiles as $profile){
        
              
                   $pix.=$profile->url;
        
               }

               return $pix;
        }

        public static function getpastorname($id){

          $profile=DB::table('profile')->where('id', $id)->first();
          return  $profile->firstname.' '.$profile->lastname;
                           
        }

        public static function getpastorcontact($id){
            $profile=DB::table('profile')->where('id', $id)->first();
            return  $profile->email.',  '.$profile->phone;
            
        }

        public static function right($id){

            $right=DB::table('pastors')
            ->where('userID', auth()->user()->id)
            ->where('churchID', $id)
            ->first();

            return $right->pastorRight;
        }


        public static function pastorright($id,$id2){
            $access="";

            $right=DB::table('pastors')
            ->where('userID', $id2)
            ->where('churchID', $id)
            ->first();
            if($right->pastorRight==1){

                $access.="Full acccess";
            }
           else if($right->pastorRight==2){

                $access.="Administrate photos, services, events, report";
            }
            return $access;
        }

}