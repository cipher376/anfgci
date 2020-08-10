@extends('layouts.pastor')
@section('content')


                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active"> Church services</a> </div>
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
                                <div class="p-2">
                                    <a href="/manage/users/edit/{{Auth::user()->id}}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                                    <a href="/manage/add_user" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
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
                    </div>
                    <!-- END: Account Menu -->
                </div>

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
                <!-- END: Top Bar -->
                <h2 class="intro-y text-lg font-medium mt-10">
                  Services
                </h2> <br/>
               
{{ csrf_field() }} 
<a href="/pastor/branch" class="button w-32 mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white"> <i data-feather="chevron-left" class="w-4 h-4"></i> Go Back</a>
               
              
          
                
                <div class="grid grid-cols-12 gap-6 mt-5">

               
                       
                   
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <div class="intro-y datatable-wrapper box p-5 mt-5">
                    <table class="table table-report table-report--bordered display datatable w-full" style="font-size:14px;">
                        <thead>
                            <tr>
                                
                                <th class="border-b-2 whitespace-no-wrap">PROGRAM</th>
                                 <th class="border-b-2 whitespace-no-wrap">DATE</th>
                                <th class="border-b-2 whitespace-no-wrap">DURATION</th>
                               
                                <th class="border-b-2 whitespace-no-wrap">SERMON</th>
                               
                                <th class="border-b-2 text-center whitespace-no-wrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                 <td class="border-b">
                                    <div class="font-medium whitespace-no-wrap">{{ ucwords($service->title)}}</div>
                                </td>
                               
                                <td class="text-center border-b">{{ $service->month }} </td>

                                <td class="text-center border-b">
                                    
                                
                                
                                
                                {{ $service->time }}
                            
                            </td>
                               
                                <td class="text-center border-b"><button class="button px-2 mr-1 mb-2 bg-theme-7 text-white tooltip cursor-pointer" title="Add Service Sermon" > <span class="w-5 h-5 flex items-center justify-center"> <i data-feather="file-plus" class="w-4 h-4"></i> </span> </button></td>
                               
                                <td class="border-b w-5">
                                    <div class="flex sm:justify-center items-center">
                                    <a href="/pastor/services/delete/{{ $service->serviceID}}" class="button px-2 mr-1 mb-2 bg-theme-6 text-white"> <span class="w-5 h-5 flex items-center justify-center"> <i data-feather="trash" class="w-4 h-4"></i> </span> </a>
                                             </div>
                                </td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
                    </div>
                    <!-- END: Data List -->
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
    
    window.location="/manage/users/delete/"+$('#app_id').val();
   
}
</script>
