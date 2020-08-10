@extends('layouts.pastor')
@section('content')



                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Videos</a> </div>
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
                                    <div class="text-xs text-theme-41"> <?php if(Auth::user()->role=="manage"){ echo"Super Admin"; }else if(Auth::user()->role=="manage-sub"){ echo"Admin";} ?></div>
                                </div>
                                <?php if(Auth::user()->role=="manage"){ ?>
                                <div class="p-2">
                                    <a href="/manage/users/edit/{{Auth::user()->id}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                    <a href="add_user" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                                    <a href="/manage/users/edit/{{Auth::user()->id}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                                 </div>
                                <?php }?>
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
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->

                @if($errors->any())
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6"> 
    
   
        <Ol>
      <li>  {{$errors->first()}}</li>
        </Ol>
    </div>

@endif

                @if(session('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> 
{{session('success')}}
    </div>
@endif


                <h2 class="intro-y text-lg font-medium mt-10">
                  Free Videos
                </h2>
<br/>
<form method="POST" action="{{route('videopostallow')}}">
{{ csrf_field() }} 
                <a href="/pastor/add_video" class="button text-white bg-theme-1 shadow-md mr-2">Add Video </a>
               
                <a href="/pastor/premium_video" class="button w-24 mr-1 mb-2 bg-theme-9 text-white">Premium Videos </a>
               
                  
                <button class="button w-24 mr-1 mb-2 border text-gray-700" name="action" value="activate">Activate</button> 
                <button class="button w-24 mr-1 mb-2 border text-gray-700" name="action" value="deactivate">Deactivate</button> 
              
                <div class="grid grid-cols-12 gap-6 mt-5">

               
                       
                   
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5 mt-5">
                    <table class="table table-report table-report--bordered display datatable w-full" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="border-b-2 whitespace-no-wrap">TITLE</th>
        
                                <th class="border-b-2 text-center whitespace-no-wrap">AUTHOR</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">ID</th>
                                <th class="border-b-2 text-center whitespace-no-wrap">STATUS</th>
                               
                                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                            <tr>
                            <td class=""> <input type="checkbox" name="video[]" class="input border mr-2" id="vertical-checkbox-chris-evans" value="{{$video->videoID}}"></td>
                   
                                <td class="border-b">
                                    <div class="font-medium whitespace-no-wrap">{{ $video->title }}</div>
                                    
                                </td>
                                <td class="w-40 border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $video->artist }}</div>
                                </td>
                              
                                <td class="w-40 border-b">
                                <div class="font-medium whitespace-no-wrap">{{ $video->url }}</div>
                                </td>

                                <td class="w-40 border-b">
                                <?php if($video->status==1){ ?>
                                    <div class="flex items-center sm:justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                                   <?php  } else{?>
                                    <div class="flex items-center sm:justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                                  <?php  } ?> </td>
                                
                                <td class="border-b w-5">
                                    <div class="flex sm:justify-center items-center">
                                     
                                      
                                           
                                        <a class="flex items-center text-theme-6" id="deleteUser{{ $video->videoID}}" data-userid="{{$video->videoID}}" href="javascript:void(0)" onclick="showAlert({{ $video->videoID}});" >
                                         <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                       
                                    
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                                </form>   <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                   
                    <!-- END: Pagination -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->
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
                <!-- END: Delete Confirmation Modal -->
            
@endsection
<script>


function showAlert(photo){
    var id=photo;
    var userID=$('#deleteUser'+id).attr('data-userid');
    $('#app_id').val(userID); 
   $('#delete-confirmation-modal').modal('show'); 
   
}

function senddel(){
    
    window.location="/pastor/videos/deletefree/"+$('#app_id').val();
   
}
</script>