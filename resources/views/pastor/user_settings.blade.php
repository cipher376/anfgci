<?php   use \App\Http\Controllers\ManageController; ?>
@extends('layouts.pastor')
@section('content')


<!-- BEGIN: Top Bar -->
<div class="top-bar">
@foreach($churches as $church)
<?php $services=ManageController::showServices($church->churchID) ?>
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="/manage/churches" class="breadcrumb--active">Branch</a>  <i data-feather="chevron-right" class="breadcrumb__icon"></i>{{ strip_tags(htmlspecialchars_decode(substr($church->name, 0,70) ))}} </div>
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

                @if ($errors->any())

<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6"> 
    
   
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
</ul>
    </div>
@endif


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
                       
                        <!-- END: Display Information -->
                        <!-- BEGIN: Personal Information -->
                        <div class="intro-y box lg:mt-5">
                            <div class="flex items-center p-5 border-b border-gray-200">
                                <h2 class="font-medium text-base mr-auto">
                                    Add/Rights settings
                                </h2>
                            </div>
                            <div class="p-5"> 
                            <form  action="/manage/church/user_settings/{{ $church->churchID }}" method="post">
                            {{ csrf_field() }}   
                            <div>
                                            <label>Enter pastor email</label>
                                            <input name="email" type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" placeholder="Input text" value=" {{ old('email') }}" >
                                        </div>

                                        <div class="mt-3"> <label><b>Access right</b></label>
     <div class="flex flex-col sm:flex-row mt-2">
         <div class="flex items-center text-gray-700 mr-2"> <input type="radio" class="input border mr-2" id="horizontal-radio-chris-evans" name="right" value="1"> <label class="cursor-pointer select-none" for="horizontal-radio-chris-evans">Full Access</label> </div>
         <div class="flex items-center text-gray-700 mr-2 mt-2 sm:mt-0"> <input type="radio" class="input border mr-2" id="horizontal-radio-liam-neeson" name="right" value="2"> <label class="cursor-pointer select-none" for="horizontal-radio-liam-neeson">Administrate Photo, Services and Report</label> </div>
     </div>

     <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                        
                         <button class="button w-40 justify-center block bg-theme-1 text-white ml-2">Add</button>
                     </div>
 </div>
                                
</form>  
                            </div>
                        </div>
                        <!-- END: Personal Information -->
                    </div>
                </div>

              



                      
                               


                                <div class="modal" id="header-footer-modal-preview">
     <div class="modal__content">
         <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
             <h2 class="font-medium text-base mr-auto">Service</h2> 
             
         </div>
         <form  action="/pastor/church/services/{{ $church->churchID }}" method="post">
         {{ csrf_field() }} 
         <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
             <div class="col-span-12 sm:col-span-12"> <label>Program Title</label> <input name="title" type="text" class="input w-full border mt-2 flex-1" placeholder="title"> </div>
             <div class="col-span-12 sm:col-span-12"> <label>Month/Day/Year</label> <input name="month" type="text" class="datepicker input w-full border"> </div>
            
             <div class="col-span-12 sm:col-span-12"> <label>Time</label> <input type="text" name="time" class="input w-full border mt-2 flex-1" placeholder=""> </div>
                                    
         </div>
         <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="submit" class="button w-20 bg-theme-1 text-white">Send</button> </div>
    </form>  </div>
 </div>

                            </div>
                        </div>
                        <!-- END: Multiple Item -->
                        <!-- BEGIN: Responsive Display -->
                        
                        <!-- END: Responsive Display -->
                    </div>
                   
                </div>

                
  @endforeach
               
@endsection