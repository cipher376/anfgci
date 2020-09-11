<?php   use \App\Http\Controllers\ManageController; ?>
@extends('layouts.pastor')
@section('content')

<?php $serviceid=""; ?>
<!-- BEGIN: Top Bar -->
<div class="top-bar">
@foreach($churches as $church)
<?php $services=ManageController::showServices($church->churchID) ?>
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="/manage/churches" class="breadcrumb--active">Branch</a>  <i data-feather="chevron-right" class="breadcrumb__icon"></i>{{ strip_tags(htmlspecialchars_decode(substr($church->name, 0,70) ))}} </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                   
                    <!-- END: Search -->
                    <!-- BEGIN: Notifications -->
                 
                    <!-- END: Notifications -->
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8 relative">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in">
                            <img alt="Midone Tailwind HTML Admin Template" src="{{ asset('dist/images/profile-12.jpg') }}">
                        </div>
                        <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                            <div class="dropdown-box__content box bg-theme-38 text-white">
                                <div class="p-4 border-b border-theme-40">
                                    <div class="font-medium"> {{ Auth::user()->name }}</div>
                                    <div class="text-xs text-theme-41"> {{ Auth::user()->role }}</div>
                                </div>
                                <div class="p-2">
                                    <a href="/manage/users/edit/{{Auth::user()->id}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                    <a href="add_user" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                                    <a href="/manage/users/edit/{{Auth::user()->id}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                                 </div>
                                <div class="p-2 border-t border-theme-40">
                                
                                    <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Notifications -->
                   
                </div>
                <!-- END: Top Bar -->
                @if(session('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> 
{{session('success')}}
    </div>
@endif


<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                    {{ ucfirst($church->name) }}
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Profile Menu -->
                    <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">

                    
         @include('layouts.pastor_church_sidebar')
                       
                    </div>
                    <!-- END: Profile Menu -->
                    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                        <!-- BEGIN: Display Information -->
                       
                        <div class="lg:mt-5">
                            
                            <h2 class="font-medium text-base mr-auto">
                                    Services
                                 </h2>
                                <br/>
                         </div>

                         <div class="w-full sm:w-auto flex mt-4 sm:mt-0" style="text-align:right">
                        <a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"  class="button text-white bg-theme-1 shadow-md mr-2" >Add Service</a>
                        
                    </div><br/> 
                        
                        <div class="intro-y col-span-12 md:col-span-6">

                        
                        <?php if($services->count()<1){ ?>

<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-17 text-theme-11"> <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i> No records found </div>

<?php }else{?>

                        @foreach($services as $service)
                        <?php $serviceid=$service->serviceID;?>
                        <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-gray-200">
                                
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="font-medium">{{ $service->title}}</a> 
                                    <div class="text-gray-600 text-xs"><span><b>Date posted</b> {{ \Carbon\Carbon::parse($service->created_at)->diffForHumans() }} </span> <span style="padding-left:10px"> <b>Duration</b> {{ $service->time}} </span> <span><b>Date of service</b> {{ $service->month}} </span><br/> </div>
                                </div>
                                <div class="flex -ml-2 lg:ml-0 lg:justify-end mt-3 lg:mt-0">

                                <?php if(!empty($service->sermonID)){?> 
                    
                    <a href="/pastor/church/{{$church->churchID}}/service/sermon/view/{{ $service->serviceID }}" class="w-8 h-8 rounded-full flex items-center justify-center border ml-2 text-gray-500 zoom-in tooltip" title="View Sermon of service"> <i class="w-3 h-3 fill-current" data-feather="eye"></i> </a>
                   
                  <?php }else{?> 
                    <a id="service{{ $service->serviceID}}" data-userid="{{$service->serviceID}}" href="javascript:void(0)" onclick="serviceId({{ $service->serviceID}});" class="w-8 h-8 rounded-full flex items-center justify-center border ml-2 text-gray-500 zoom-in tooltip" title="Click to add sermon of service">             
                     <i data-feather="file-plus" class="w-4 h-4"></i></a></td>
                   
               <?php }?>

                                     <a id="deleteUser{{ $service->serviceID}}" data-userid="{{$service->serviceID}}" href="javascript:void(0)" onclick="showAlert({{ $service->serviceID}});" class="w-8 h-8 rounded-full flex items-center justify-center border ml-2 text-gray-500 zoom-in tooltip" title="Delete this service"> <i class="w-3 h-3 fill-current" data-feather="trash-2"></i> </a>
                                </div>
                            </div>
                           
                        </div>
                        <br/>
                        @endforeach

                  <?php }?>
                        
                    </div>

                    <br/><br/>
                    {{ $services->links() }}
                        <!-- END: Display Information -->
                        <!-- BEGIN: Personal Information -->
                        
                        <!-- END: Personal Information -->
                    </div>

                   
                </div>

              
       


                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-12">
                        <!-- BEGIN: Single Item -->
                        
                        <!-- END: Single Item -->



                       



                        <!-- BEGIN: Multiple Item -->
                      
                               


                                <div class="modal" id="header-footer-modal-preview">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Service</h2> 
             
         </div>
         <form  action="/manage/church/services/{{ $church->churchID }}" method="post">
         {{ csrf_field() }} 
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
             <div class="col-span-12 sm:col-span-12"> <label>Program Title</label> <input name="title" type="text" class="input w-full border mt-2 flex-1" placeholder="title"> </div>
             <div class="col-span-12 sm:col-span-12"> <label>Month/Day/Year</label> <input name="month" type="text" class="datepicker input w-full border"> </div>
            
             <div class="col-span-12 sm:col-span-12"> <label>Time</label> <input type="text" name="time" class="input w-full border mt-2 flex-1" placeholder=""> </div>
                                    
         </div>
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Send</button> </div>
    </form>  </div>
 </div>


 <div class="modal" id="header-footer-modal-preview2">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">New Photo</h2> 
             
         </div>
         <form  action="/manage/churches/photo/{{ $church->churchID }}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }} 
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
             <div class="col-span-12 sm:col-span-12"> <label>Title</label> 
             <input name="title" type="text" class="input w-full border mt-2 flex-1" placeholder="title" required> </div>
             <div class="col-span-12 sm:col-span-12"> <label>Caption</label> 
             <textarea data-feature="basic" class="summernote" name="caption" required></textarea>
 </div>
            
             <div class="col-span-12 sm:col-span-12"> <label>Upload photo</label> 
             <input name="file" class="input w-full border mt-2 flex-1" type="file" required  /> </div>
                                    
         </div>
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Send</button> </div>
    </form> 




</div>
 </div>


 <div class="modal" id="header-footer-modal-preview3">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Add Sermon to Service</h2> 
             
         </div>
         <form  action="/manage/service/sermon/{{$serviceid}}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }} 
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
             <div class="col-span-12 sm:col-span-12"> <label>Title</label> 
             <input name="topic" type="text" class="input w-full border flex-1" placeholder="Sermon Topic" required>
            <input id="serviceid"  name="serviceid" type="hidden" class="input w-full border flex-1">
                          
            <div class="col-span-12 sm:col-span-12"> <label>Author</label> 
            <input name="author" type="text" class="input w-full border flex-1" placeholder="Name of minister" required>
                           
 </div>

 <div class="col-span-12 sm:col-span-12"> <label>Sermon</label> 
            <textarea data-feature="basic" class="summernote" name="sermon" required></textarea> 
 
 </div>
            
             <div class="col-span-12 sm:col-span-12"> <label>Upload PDF Version of sermon</label> 
             <input name="file" class="input w-full border mt-2 flex-1" type="file" required  /> </div>
                                    
         
         
         <div class="px-5 py-3 text-right border-t border-gray-200"> 
             <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button>
              <button type="submit" class="button w-20 bg-theme-1 text-white">Send</button>
             </div>
    </form> 




</div>
 </div>

                            </div>
                        </div>
                        <!-- END: Multiple Item -->
                        <!-- BEGIN: Responsive Display -->
                        <form action="" method="post" >
                <div class="modal" id="delete-confirmation-modal">

               {{ csrf_field() }}

                    <div class="modal__content">
                        <div class="p-5 text-center">
                            <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> 
                            <div class="text-3xl mt-5">Are you sure?</div>
                            <div class="text-gray-600 mt-2">Do you really want to delete these records? This process cannot be undone.</div>
                            <input type="hidden", name="id" id="app_id">
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                            <button type="submit" class="button w-24 bg-theme-6 text-white" onclick="senddel();" >Delete</button>
                        </div>
                    </div>
                </div>
                </form>
                        <!-- END: Responsive Display -->
                    </div>
                   
                </div>

                
  @endforeach
               
@endsection

<script>


function showAlert(photo){
    var id=photo;
    var userID=$('#deleteUser'+id).attr('data-userid');
    $('#app_id').val(userID); 
   $('#delete-confirmation-modal').modal('show'); 
   
}


function serviceId(sid){
    var id=sid;
    var serviceID=$('#service'+id).attr('data-userid');
    $('#serviceid').val(serviceID); 
   $('#header-footer-modal-preview3').modal('show'); 
   
}

function senddel(){
    
    window.location="/manage/services/delete/"+$('#app_id').val();
   
}
</script>