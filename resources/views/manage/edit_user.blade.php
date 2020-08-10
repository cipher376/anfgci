<?php   use \App\Http\Controllers\ManageController; ?>
@extends('layouts.manage')
@section('content')

<?php $countries=ManageController::showCountries() ?>
<!-- BEGIN: Top Bar -->
<div class="top-bar">
    @foreach($users as $user)
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Administration</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Account</a> </div>
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
                    </div>
                    <!-- END: Account Menu -->
                </div>
                <!-- END: Top Bar -->




                <div class="intro-y flex items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                   User Information
                </h2>
            </div>
                

                
                            

         <div class="intro-y box py-10 sm:py-8 mt-5">
             
             <form method="POST" action="{{ route('user.update',$user->id) }}" enctype="multipart/form-data">
             {{ method_field("PUT")}}

           

                <div class="px-5 sm:px-20 mt-5 pt-10 border-gray-200">

                @if ($errors->any())

<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-31 text-theme-6"> 
    
   
        <Ol>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </Ol>
    </div>
@endif


@if(session('success'))
<div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> 
{{session('success')}}
    </div>
@endif



                {{ csrf_field() }}         
                     
                
         
                                         <div class="grid grid-cols-12 gap-5">
                                       
                                        
                                             <div class="col-span-12 xl:col-span-4">
                                                 
                                                 <div class="border border-gray-200 rounded-md p-5">
                                                     <div class="w-40 h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                                     <img id="blah" alt="" class="rounded-md" src="{{ $user->url }}">
                                    
                                                                                                   </div>
                                                     <div class="w-40 mx-auto cursor-pointer relative mt-5">
                                                         <button type="button" class="button w-full bg-theme-1 text-white">Add Photo</button>
                                                         <input name="file" type="file" onchange="readURL(this);" class="w-full h-full top-0 left-0 absolute opacity-0">
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-span-12 xl:col-span-8">
                                             <div class="p-5">
                                         <div class="grid grid-cols-12 gap-5">
                                             <div class="col-span-12 xl:col-span-6">
                                             <div class="mt-3">
                                                     <label>Firstname</label>
                                                     <input name="firstname" type="text" class="input w-full border mt-2" value="{{ $user->firstname }}">
                                                 </div>
                                                 <div class="mt-3">
                                                     <label>Phone number</label>
                                                     <input name="phone" type="text" class="input w-full border mt-2" value="{{ $user->phone }}" >
                                                 </div>
                                                
                                                 <div class="mt-3">
                                                     <label>State</label>
                                                     <input name="state" type="text" class="input w-full border mt-2" value="{{ $user->state }}">
                                                 </div>
                                             </div>
                                             <div class="col-span-12 xl:col-span-6" data-select2-id="21">
                                             <div class="mt-3">
                                                     <label>Lastname</label>
                                                     <input name="lastname" type="text" class="input w-full border mt-2" value="{{ $user->lastname }}">
                                                 </div>
                                                 <div class="mt-3">
                                                     <label>Town</label>
                                                     <input name="town" type="text" class="input w-full border mt-2" value="{{ $user->town }}">
                                                 </div>
                                               
                                                 <div class="mt-3">
                                                     <label>Country</label>
                                                     <select name="country" class="input w-full border mt-2" style="width:100%">
                      <option value="{{ $user->country }}">{{ $user->country }}</option>
                     @foreach($countries as $country)
                      <option>{{ $country->country_name}}</option>
                      @endforeach
                  </select>  </div>
                                             </div>
                                             <div class="intro-y col-span-12 sm:col-span-12">
                            <div class="mb-2">Email</div>
                           
                            <input disabled name="email" type="email" class="input w-full border flex-1" value="{{ $user->email }}" placeholder="example@gmail.com"  required autofocus>
                        </div>

                        <div class="intro-y col-span-12 sm:col-span-12">
                            <div class="mb-2">Role</div>
                            <select name="role" class="input w-full border flex-1">
                            <option value="{{$user->role}}"><?php if($user->role=="manage"){ echo"Super Admin"; }else if($user->role=="manage-sub"){ echo"Admin";}else if($user->role=="user"){ echo"user";} ?></option>
                                <option value="manage">Super Admin</option>
                                <option value="manage-sub">Admin</option>
                                <option value="user">User</option>
                               
                                
                            </select>
                        </div>
                                         </div>
                                         
                                     </div>    </div>
                                         </div>
                                         
         
         



                                         

                   
                    <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">

                       
                       
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                           
                        <button class="button w-40 shadow-md mr-1 mb-2 bg-theme-9 text-white">Save </button>
                        </div>
                    </div>
                </div>
         
         
                                         
                                     </div>

                                     
                                  
                                                         
                                 </div>








             </form>
             @endforeach
            </div>
@endsection