<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\photos;
use App\Location;
use App\profile;
class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$sermons = DB::select('select * from sermons where status=1 order by id DESC');
       $profiles= DB::table('profile')->where('id',auth()->user()->id)->get();
       if( $profiles->count()<1){

        return view('user.profile',['profiles'=>$profiles]);

       }else{
        return view('user.index');

       }
    }

    public function profile()
    {
        //$sermons = DB::select('select * from sermons where status=1 order by id DESC');
      // $sermons= DB::table('sermons')->where('status','1')->paginate(10);
        return view('user.profile');
    }

    public function addprofile(){

        $validator=$this->validate(request(),[
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'phone' => 'required|string',
            'town' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'file' => 'required|mimes:jpeg,JPEG,png',
            
            ],
            [
               
                ]);

                if(count(request()->all()) > 0){


                     ////// move file to upload folder ////////////////

                     $file = request()->file('file');
                     $original_name = strtolower(trim($file->getClientOriginalName()));
                     $fileName =  time().rand(100,999).$original_name;
                     $filePath = 'profilePhoto';
                     $file->move($filePath,$fileName);

                     //insert photo into photo table /////////////

                     $photos = new photos();

                        $photos->type= '1';
                        $photos->title= 'profile photo';
                        $photos->caption= 'profile photo';
                        $photos->url=asset('/profilePhoto/'.$fileName);
                        if($photos->save()){


                        //insert address into address table /////////////


                        $address = new Location;
    
                            $photoid = $photos->id;
                            $address->town = request()->input('town');
                            $address->state = request()->input('state');
                            $address->country = request()->input('country');
                            $address->lat =" ";
                            $address->lng =" ";
                            if($address->save()){
    
                            $profile = new profile;

                    $profile->firstname = request()->input('firstname');
                    $profile->lastname = request()->input('lastname');
                    $profile->email =  auth()->user()->email;
                    $profile->id =  auth()->user()->id;
                    $profile->addressID = $address->id;
                    $profile->phone = request()->input('phone');
                   
                    $profile->photoID = $photoid;
                    $profile->save();      
                    return view('user.index');
    
    
                        }



                   
                    
                    


                    }}       

    }

    public function searchquery(Request $request){
        $searchterm = $request->input('search-term');
        
        $searchresults = DB::table('sermons')->where('topic', 'like', $searchterm.'%')->get();

        return view('user.search',['sermons'=>$searchresults]);



    }

    public function show_sermon($id)
    
    {
        $sermons = DB::select('select * from sermons where id='.$id);
     
    return view('user.read_sermon',['sermons'=>$sermons]);
       
    }

    public function audios()
    {
       // $audios = DB::select('select * from audios ');
        $audios= DB::table('audios')->get();
        return view('user.audio',['audios'=>$audios]);
    }

    public function listen_audio($id)
    {
       
        $audios= DB::table('audios')->where('id','!=', $id)->paginate(5); 
        $lists = DB::select('select * from audios where id='.$id);
        return view('user.listen_audio',['lists'=>$lists],['audios'=>$audios]);
    }

}
