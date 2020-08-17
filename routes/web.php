<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use \App\Http\Controllers\ManageController;
use App\Http\Resources\combinedUserCollection;
use App\Http\Resources\UserCollection;
use App\Http\Resources\churchCollection;
use App\Http\Resources\churchResource;
use App\Http\Resources\allChurchPhotos;
use App\Http\Resources\CResourcePhotoPaginate;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserProfilePhotoResource;
use App\Http\Resources\pastors;
use App\Http\Resources\pastordetail;
use App\Http\Resources\pastorspaging;
use App\Http\Resources\pastorsAudio;
use App\Http\Resources\pastorsAudioSingle;
use App\Http\Resources\pastorsAudioSingleExclude;
use App\Http\Resources\pastorsAudioSingleExcludePaging;
use App\Http\Resources\pastorsVideos;
use App\Http\Resources\pastorsVideosSingle;
use App\Http\Resources\pastorsVideoSingleExclude;
use App\Http\Resources\pastorsVideoSingleExcludePaging;
use App\Http\Resources\pastorsSermons;
use App\Http\Resources\pastorsSermonsSingle;
use App\User;
use App\profile;
use App\photos;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/pastor', 'PastorController@index')->name('pastor');
Route::get('pastor/sermons', 'PastorController@sermons')->name('sermons');
Route::get('pastor/add_sermon', 'PastorController@add_sermons')->name('add_sermon');
Route::post('pastor/add_sermon', 'PastorController@store_sermons')->name('add_sermon');
Route::get('pastor/sermons/view/{sermon}', 'PastorController@show')->name('sermons.view');
Route::get('pastor/sermons/delete/{sermon}', 'PastorController@destroy')->name('sermons.delete');
Route::put('pastor/sermons/edit/{sermon}', 'PastorController@update')->name('serm.update');
Route::get('pastor/sermons/edit/{sermon}', 'PastorController@edit')->name('sermons.edit');
Route::get('pastor/churches/delete/{church}', 'PastorController@destroyChurch')->name('church.delete');
Route::get('pastor/add_church', 'PastorController@add_church')->name('add_church');
Route::post('pastor/add_church', 'PastorController@store_churches')->name('add_church');
Route::get('pastor/churches/edit/{church}', 'PastorController@churchEdit')->name('church.edit');
Route::put('pastor/churches/edit/{church}', 'PastorController@churchUpdatepastor')->name('church.updatepastor');
Route::get('pastor/churches/view/{church}', 'PastorController@showChurch')->name('church.view');
Route::post('pastor/church/services/{church}', 'PastorController@addService')->name('add.service');
Route::get('pastor/branch', 'PastorController@churches')->name('churches');
Route::get('pastor/church/services/{church}', 'PastorController@pullservices')->name('churchservice');
Route::get('pastor/services/delete/{services}', 'PastorController@deleteServices')->name('deleteServices');

Route::get('pastor/service/sermon/{services}', 'PastorController@serviceSermon')->name('serviceSermon');
Route::post('pastor/service/sermon/{services}', 'PastorController@storeSermons')->name('serviceSermon');

Route::get('pastor/churches/photo/{church}', 'PastorController@addPhoto')->name('addPhoto');
Route::post('pastor/churches/photo/{church}', 'PastorController@add_photo')->name('store_photo');
Route::post('pastor/sermons/activation/', 'PastorController@postallow')->name('postallow');
Route::get('/pastor/search', 'PastorController@searchquery')->name('search');
Route::get('pastor/profile/{profile}', 'PastorController@profile')->name('profile');
Route::put('pastor/profile/{profile}', 'PastorController@updateprofile')->name('updateprofile');
Route::get('/pastor/video_list', 'PastorController@allvideo')->name('allvideos');
Route::post('pastor/add_video', 'PastorController@add_video')->name('addvideo');
Route::get('pastor/add_video', 'PastorController@video')->name('video');
Route::get('/pastor/videos/deletefree/{video}', 'PastorController@delete_free_video')->name('delete_free_video');
Route::get('pastor/premium_video', 'PastorController@premiumvideo')->name('premiumvideo');
Route::get('pastor/premium_add_video', 'PastorController@add_premium')->name('add_premium_video');
Route::post('pastor/premium_add_video', 'PastorController@storePremiumVideos')->name('storePremiumVideos');
Route::post('pastor/videos/activation/', 'PastorController@videopostallow')->name('videopostallow');
Route::get('/pastor/videos/delete/{video}', 'PastorController@delete_video')->name('delete_video');


Route::get('pastor/audios', 'PastorController@audios')->name('audios');
Route::get('pastor/add_audio', 'PastorController@add_audio')->name('add_audio');
Route::post('pastor/add_audio', 'PastorController@store_audio')->name('store_audio');
Route::post('pastor/audio/activation/', 'PastorController@audioallow')->name('audioallow');
Route::get('/pastor/audio/delete/{audio}', 'PastorController@delete_audio')->name('delete_audio');
Route::get('/pastor/audio/listen/{audio}', 'PastorController@listen_audio')->name('listen_audio');



Route::get('/manage', 'ManageController@index')->name('manage');
Route::get('manage/sermons', 'ManageController@sermons')->name('sermons');
Route::get('manage/churches/view/album/{church}', 'ManageController@album')->name('album');
Route::get('manage/church/user_settings/{church}', 'ManageController@usersettings')->name('usersettings');
Route::post('manage/church/user_settings/{church}', 'ManageController@add_pastor')->name('add_pastor');

Route::get('manage/profile/{profile}', 'ManageController@profile')->name('profile');
Route::put('manage/profile', 'ManageController@updateprofile')->name('update.profile');


Route::get('manage/add_sermon', 'ManageController@add_sermons')->name('add_sermon');
Route::post('manage/add_sermon', 'ManageController@store_sermons')->name('add_sermon');

Route::get('manage/churches/photo/{church}', 'ManageController@add_photo')->name('add_photo');
Route::post('manage/churches/photo/{church}', 'ManageController@store_photo')->name('store_photo');
Route::get('manage/churches/{church_id}/photo/edit/{photo_id}', 'ManageController@edit_photo')->name('edit_photo');
Route::put('manage/churches/{church_id}/photo/edit/{photo_id}', 'ManageController@update_photo')->name('update_photo');
Route::get('manage/photo/delete/{photo_id}', 'ManageController@delete_photo')->name('delete_photo');
Route::get('manage/church/view/photodetail/{photo_id}', 'ManageController@photodetail')->name('photodetail');
Route::get('manage/church/services/{church}', 'ManageController@showChurchservices')->name('showChurchservices');
Route::post('manage/service/sermon/{sermon}', 'ManageController@serviceSermons')->name('serviceSermons');

Route::get('manage/church/{church}/service/sermon/view/{sermon}', 'ManageController@serviceSermonx')->name('serviceSermonx');
Route::get('manage/church/events/{church}', 'ManageController@events')->name('events');
Route::post('manage/church/events/{church}', 'ManageController@store_events')->name('store_events');




Route::get('manage/churches', 'ManageController@churches')->name('churches');
Route::get('manage/churches/edit/{church}', 'ManageController@churchEdit')->name('church.edit');
Route::put('manage/churches/edit/{church}', 'ManageController@churchUpdate')->name('church.update');
Route::get('manage/add_church', 'ManageController@add_church')->name('add_church');
Route::post('manage/add_church', 'ManageController@store_churches')->name('add_church');
Route::get('manage/churches/delete/{church}', 'ManageController@destroyChurch')->name('church.delete');
Route::get('manage/churches/view/{church}', 'ManageController@showChurch')->name('church.view');
Route::post('manage/church/services/{church}', 'ManageController@addService')->name('add.service');

Route::get('manage/users', 'ManageController@users')->name('users');
Route::get('manage/add_user', 'ManageController@add_user')->name('add_user');
Route::post('manage/add_user', 'ManageController@store_users')->name('add_user');
Route::put('manage/users/edit/{edit}', 'ManageController@update_user')->name('user.update');
Route::get('/manage/users/edit/{user}', 'ManageController@edit_users')->name('edit_user');
Route::post('/manage/users/activation/', 'ManageController@allow_user')->name('allow_users');
Route::post('manage/videos/activation/', 'ManageController@videopostallow')->name('videopostallow');
Route::get('/manage/videos/deletefree/{video}', 'ManageController@delete_free_video')->name('delete_free_video');



Route::get('manage/audios', 'ManageController@audios')->name('audios');
Route::get('manage/add_audio', 'ManageController@add_audio')->name('add_audio');
Route::post('manage/add_audio', 'ManageController@store_audio')->name('store_audio');
Route::post('manage/audios/multipledelete/', 'ManageController@audioMultipleDelete')->name('audios.multipledel');
Route::get('/manage/audio/delete/{audio}', 'ManageController@delete_audio')->name('delete_audio');
Route::get('/manage/audio/listen/{audio}', 'ManageController@listen_audio')->name('listen_audio');

Route::get('manage/add_video', 'ManageController@video')->name('video');
Route::get('manage/video_list', 'ManageController@allvideo')->name('allvideo');
Route::post('manage/add_video', 'ManageController@add_video')->name('add_video');
Route::get('/manage/videos/delete/{video}', 'ManageController@delete_video')->name('delete_video');

Route::get('manage/sermons/view/{sermon}', 'ManageController@show')->name('sermons.view');
Route::get('manage/sermons/edit/{sermon}', 'ManageController@edit')->name('sermons.edit');
Route::put('manage/sermons/edit/{sermon}', 'ManageController@update')->name('sermons.update');
Route::get('manage/sermons/delete/{sermon}', 'ManageController@destroy')->name('sermons.delete');

Route::post('manage/sermons/activation/', 'ManageController@postallow')->name('sermons.postallow');
Route::get('manage/churches/gallery/{church}', 'ManageController@gallery')->name('church.gallery');


Route::get('/manage/search', 'ManageController@searchquery')->name('search');
Route::get('/user/search', 'UserController@searchquery')->name('search');
Route::get('user/sermons/view/{sermon}', 'UserController@show_sermon')->name('sermons.show');
Route::get('user/audios', 'UserController@audios')->name('audios');
Route::get('/user/audio/listen/{audio}', 'UserController@listen_audio')->name('listen_audio');

Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/profile', 'UserController@profile')->name('profile');
Route::post('/user/profile', 'UserController@addprofile')->name('add.profile');

Route::get('/manage/users/delete/{user}', 'ManageController@delete_users')->name('delete_user');
Route::get('/manage/services/delete/{service}', 'ManageController@delete_service')->name('delete_service');

Route::get('manage/premium_video', 'ManageController@premiumvideo')->name('premiumvideo');
Route::get('manage/premium_add_video', 'ManageController@add_premium')->name('add_premium_video');
Route::post('manage/premium_add_video', 'ManageController@store_premium_videos')->name('store_premium_videos');




////////////////////////// API START HERE /////////////////////////////////////////////////////////

//////////////////////// users object ////////////////////////////////////////////////////////////
//Route::get('api/users', 'ApiController@users');
//Route::get('api/users/{user}', 'ApiController@singleuser');


Route::get('api/users', function () {
    return new UserCollection(User::whereIn('role',['user'])->get());
});

Route::get('api/users/{user}', function ($id) {
    $users =User::find($id);
    
    return new UserResource($users);
});

Route::get('api/users/{user}/profile', function ($id) {


    $users = DB::table('profile')

    ->select('profile.firstname','profile.lastname','profile.email','profile.phone','address.country','address.state','address.town')
    
    ->join('address','address.addressID','=','profile.addressID')
    
    ->where(['id' => $id])
    
    ->get();



    return new UserProfileResource($users);
});

Route::get('api/users/{user}/profile/photo', function ($id) {
   
    //$profilex = profile::where('id', '=', $id)->first();
    //$profiles =profile::find($profilex->photoID)->photos;

    $profiles= DB::table('profile')

    ->select('profile.firstname','profile.lastname','profile.email','profile.phone','photos.url','address.country','address.state','address.town')
    
    ->join('photos','photos.photoID','=','profile.photoID')
    ->join('address','address.addressID','=','profile.addressID')
    
    ->where(['id' => $id])
    
    ->get();

    return new UserProfilePhotoResource($profiles);
});


Route::get('api/users/profile/photo', function () {
   

    $profiles= DB::table('profile')
    ->select('profile.firstname','profile.lastname','profile.email','profile.phone','photos.url','address.country','address.state','address.town')
    ->join('address','address.addressID','=','profile.addressID') 
    ->join('photos','photos.photoID','=','profile.photoID')
    ->paginate(10);

    return new combinedUserCollection($profiles);
});
/////////////////////////////////// CHURCH API ///////////////////////////////////////////

Route::get('api/churches/', function () {

    $churches= DB::table('churches')
    ->select('churches.churchID','churches.name','churches.est_date','address.country','address.state','address.town')
    ->join('address','address.addressID','=','churches.addressID') 
    ->paginate(10);
    return new ChurchCollection($churches);
});


Route::get('api/churches/{church}', function ($id) {

    $churches= DB::table('churches')
    ->select('churches.churchID','churches.name','churches.note','churches.est_date','address.country','address.state','address.town')
    ->join('address','address.addressID','=','churches.addressID') 
    ->where(['churchID' => $id])
    ->get();

    return  ChurchResource::collection($churches);
});

Route::get('api/churches/{church}/photos/page/all', function ($id) {
   
    $photos= DB::table('church_photos')
    ->select('photos.url')
    ->join('photos','photos.photoID','=','church_photos.photoID') 
    ->where(['churchID' => $id])
    ->paginate();

    return new allChurchPhotos($photos);
    


});

Route::get('api/churches/{church}/photos/page/{pag}', function ($id,$id2) {
    $page=$id2;
    $churches= DB::table('churches')
    ->select('churches.churchID','churches.name','churches.note','churches.est_date','address.country','address.state','address.town')
    ->join('address','address.addressID','=','churches.addressID') 
    ->where(['churchID' => $id])
    ->get();

    $churchPhotos = ManageController::showChurchPhotosPag($id,$id2);
    $collection = CResourcePhotoPaginate::collection($churches);
    return $collection->additional(['photos' => $churchPhotos]);


});


//////////////////////////////// Pastors API //////////////////////////////

Route::get('api/pastors/', function () {

    $pastors= DB::table('pastors')
    ->select('profile.firstname','profile.lastname','profile.email','profile.phone')
    ->join('profile','profile.id','=','pastors.userID')
    ->paginate();
    
    return new pastors($pastors);
});



Route::get('api/pastors/{pastor}', function ($id) {

    $pastors= DB::table('profile')
    ->select('profile.id','profile.firstname','profile.lastname','profile.email','profile.phone','photos.url','address.country','address.state','address.town')
    ->join('pastors','pastors.userID','=','profile.id')
    ->join('photos','photos.photoID','=','profile.photoID')
    ->join('address','address.addressID','=','profile.addressID')
    ->where(['id' => $id])
    ->get();

    $church= DB::table('pastors')
    ->select('churches.name')
    ->join('churches','churches.churchID','=','pastors.churchID')
    ->where(['userID' => $id])
    ->first();

    
    
   // return new pastordetail($pastors);
   $collection = pastordetail::collection($pastors);
   return $collection->additional(['church' => ucwords($church->name)]);
    
});


Route::get('api/pastors/{pastor}/resources/paging/{page}', function ($id,$id2) {

    $page=$id2;
    $pastors= DB::table('profile')
    ->select('profile.id','profile.firstname','profile.lastname','profile.email','profile.phone','photos.url','address.country','address.state','address.town')
    ->join('pastors','pastors.userID','=','profile.id')
    ->join('photos','photos.photoID','=','profile.photoID')
    ->join('address','address.addressID','=','profile.addressID')
    ->where(['id' => $id])
    ->first();

    $church= DB::table('pastors')
    ->select('churches.name')
    ->join('churches','churches.churchID','=','pastors.churchID')
    ->where(['userID' => $id])
    ->first();

    
    return new pastorspaging($pastors,$page);
   //$collection = pastordetail::collection($pastors);
   //return $collection->additional(['church' => ucwords($church->name)]);
    
});


Route::get('api/pastors/{pastor}/audios', function ($id) {

    $pastors= DB::table('audios')
    ->select('audios.audioID','audios.audioType','resources.title','resources.author','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','audios.resourceID')
    ->join('photos','photos.photoID','=','audios.photoID')
    ->where(['userID' => $id])
    ->paginate();
    
    return new pastorsAudio($pastors);
    
});


Route::get('api/pastors/{pastor}/audios/{audio}', function ($id,$id2) {

    $pastors= DB::table('audios')
    ->select('audios.audioID','audios.audioType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','audios.resourceID')
    ->join('photos','photos.photoID','=','audios.photoID')
    ->where(['audioID' => $id2])
    ->first();
    
    return new pastorsAudioSingle($pastors);
    
});
Route::get('api/pastors/{pastor}/audios/exclude/{audio}', function ($id,$id2) {

    $pastors= DB::table('audios')
    ->select('audios.audioID','audios.audioType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','audios.resourceID')
    ->join('photos','photos.photoID','=','audios.photoID')
    ->where(['audioID','!=',$id2],['userID'=>$id])
    ->get();
    
    return new pastorsAudioSingleExclude($pastors);
    
});

Route::get('api/pastors/{pastor}/audios/exclude/{audios}/paging/{page}', function ($id,$id2,$id3) {

    $pastors= DB::table('audios')
    ->select('audios.audioID','audios.audioType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','audios.resourceID')
    ->join('photos','photos.photoID','=','audios.photoID')
    ->where(['audioID','!=',$id2],['userID'=>$id])
    ->paginate($id3);
    
    return new pastorsAudioSingleExcludePaging($pastors);
    
});


Route::get('api/pastors/{pastor}/videos', function ($id) {

    $pastors= DB::table('videos')
    ->select('videos.videoID','videos.vidType','resources.title','resources.author','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','videos.resourceID')
    ->join('photos','photos.photoID','=','videos.photoID')
    ->where(['userID' => $id])
    ->paginate();
    
    return new pastorsVideos($pastors);
    
});




Route::get('api/pastors/{pastor}/videos/{video}', function ($id,$id2) {

    $pastors= DB::table('videos')
    ->select('videos.videoID','videos.vidType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','videos.resourceID')
    ->join('photos','photos.photoID','=','videos.photoID')
    ->where(['videoID' => $id2])
    ->first();
    
    return new pastorsVideosSingle($pastors);
    
});

Route::get('api/pastors/{pastor}/videos/exclude/{videos}', function ($id,$id2) {

    $pastors= DB::table('videos')
    ->select('videos.videoID','videos.vidType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','videos.resourceID')
    ->join('photos','photos.photoID','=','videos.photoID')
    ->where(['videoID','!=',$id2],['userID'=>$id])
    ->get();
    
    return new pastorsVideoSingleExclude($pastors);
    
});

Route::get('api/pastors/{pastor}/videos/exclude/{videos}/paging/{page}', function ($id,$id2,$id3) {

    $pastors= DB::table('videos')
    ->select('videos.videoID','videos.vidType','resources.title','resources.artist','resources.url','photos.url')
    ->join('resources','resources.resourceID','=','videos.resourceID')
    ->join('photos','photos.photoID','=','videos.photoID')
    ->where(['videoID','!=',$id2],['userID'=>$id])
    ->paginate($id3);
    
    return new pastorsVideoSingleExcludePaging($pastors);
    
});

Route::get('api/pastors/{pastor}/sermons', function ($id) {

    $pastors= DB::table('sermons')
    ->select('sermons.sermonID','sermons.created_at','resources.title','resources.artist','resources.url')
    ->join('resources','resources.resourceID','=','sermons.resourceID')
    ->where(['userID' => $id])
    ->paginate();
    
    return new pastorsSermons($pastors);
    
});

Route::get('api/pastors/{pastor}/sermons/{sermon}', function ($id,$id2) {

    $pastors= DB::table('sermons')
    ->select('sermons.sermonID','sermons.created_at','resources.title','resources.artist','resources.note','resources.url')
    ->join('resources','resources.resourceID','=','sermons.resourceID')
    ->where(['sermonID' => $id])
    ->get();
    
    return pastorsSermonsSingle::collection($pastors);
    
});

Route::get('api/sermons', 'ApiController@sermons');
Route::get('api/sermons/{sermon}', 'ApiController@getsermon');


Route::get('api/audios', 'ApiController@audios');
Route::get('api/audios/{audio}','ApiController@getaudio');
Route::get('api/videos', 'ApiController@videos');
Route::get('api/videos/{video}','ApiController@getvideo');


//API CRUD Functionality

////////////////sermons///////////////////////////////////////
////////create
Route::get('api/sermon/','ApiController@create_sermon');




