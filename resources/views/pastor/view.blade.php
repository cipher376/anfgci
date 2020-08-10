<?php   use \App\Http\Controllers\ManageController; ?>
@extends('layouts.pastor')
@section('content')


<!-- BEGIN: Top Bar -->
<div class="top-bar">
@foreach($sermons as $sermon)
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Sermons</a>  <i data-feather="chevron-right" class="breadcrumb__icon"></i>{{ strip_tags(htmlspecialchars_decode(substr($sermon->topic, 0,70) ))}}... </div>
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
                    </div>    <!-- END: Notifications -->
                   
                </div>
                <!-- END: Top Bar -->




              
               

       

                <div class="intro-y news p-5 box mt-8">

                
                    <!-- BEGIN: Blog Layout -->
                    <h2 class="intro-y font-medium text-xl sm:text-2xl">
                    {{ ucfirst($sermon->title) }}
                    </h2>
                    
                    <div class="intro-y text-gray-700 mt-3 text-xs sm:text-sm">
                    <div class="flex items-center  py-3 border-t border-gray-200">
                    <i data-feather="clock" class="w-4 h-4"></i><a class="text-theme-1" href="">Date Posted</a> <span class="mx-1">•</span>  {{ $sermon->created_at }} <span class="mx-1">•</span>  <i data-feather="edit-3" class="w-4 h-4"></i><a class="text-theme-1" href="">Author</a> <span class="mx-1">•</span> {{ $sermon->author }} <span class="mx-1">•</span> <i data-feather="user" class="w-4 h-4"></i> <a class="text-theme-1" href=""> Posted by</a> <span class="mx-1">•</span> {{ ucwords($sermon->postedBy) }}
                            
                            <a class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 text-theme-10 ml-auto "> </a>
                            <a href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 tooltip tooltipstered" title="Download this sermon"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share w-3 h-3"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg> </a>
                        </div> </div>
                    <br/>

                    <div class="intro-y text-justify leading-relaxed">
                   

                  <?php echo stripslashes($sermon->note); ?>
                              </div>
                    
                   
                    
                  
                    
                    <!-- END: Blog Layout -->
                    <!-- BEGIN: Comments -->
                   
                   
                  
                    <!-- END: Comments -->
                </div>
  @endforeach
               
@endsection