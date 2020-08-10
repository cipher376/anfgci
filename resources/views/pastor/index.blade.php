<?php   use \App\Http\Controllers\PastorController; ?>
@extends('layouts.pastor')

@section('content')

         <?php //$messages=PastorController::showtopics(); ?>  
         <?php $videos=PastorController::allVideos(); ?>  
         <?php $audios=PastorController::allAudios(); ?>     <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
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
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
                        <!-- BEGIN: General Report -->
                        <div class="col-span-12 mt-8">
                            <div class="intro-y flex items-center h-10">
                                <h2 class="text-lg font-medium truncate mr-5">
                                    Dashboard
                                </h2>
                                <a href="" class="ml-auto flex text-theme-1"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-5">

                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="file" class="report-box__icon text-theme-10"></i> 
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="Total Sermon Upload">  <?php  echo $sermonsx->count(); ?> Uploads<i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                                </div>
                                            </div>
                                            <a href="pastor/sermons">
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php  echo $sermonsx->count(); ?></div>
                                            <div class="text-base text-gray-600 mt-1">Sermons </div>
                                       </a> </div>
                                    </div>
                                </div>
                                
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="video" class="report-box__icon text-theme-11"></i> 
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="Total Video Upload"> <?php  echo $videos->count(); ?> Uploads <i data-feather="chevron-down" class="w-4 h-4"></i> </div>
                                                </div>
                                            </div>
                                            <a href="pastor/video_list">
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php  echo $videos->count(); ?></div>
                                            <div class="text-base text-gray-600 mt-1">Videos</div>
                                </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="music" class="report-box__icon text-theme-12"></i> 
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="Total Uploads"><?php  echo $audios->count(); ?> Uploads <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                                </div>
                                            </div>
                                            <a href="pastor/audios">
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php  echo $audios->count(); ?></div>
                                            <div class="text-base text-gray-600 mt-1">Audios</div>
                                </a> </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="book" class="report-box__icon text-theme-9"></i> 
                                                <div class="ml-auto">
                                                    <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="Total church upload"> <?php  echo $churches->count(); ?> Uploadeds <i data-feather="chevron-up" class="w-4 h-4"></i> </div>
                                                </div>
                                            </div>
                                            <a href="">
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php  echo $churches->count(); ?></div>
                                            <div class="text-base text-gray-600 mt-1">Books</div>
                                </a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: General Report -->
                        <!-- BEGIN: Sales Report -->
                        
                        
                        <!-- END: Weekly Top Seller -->
                        <!-- BEGIN: Sales Report -->
                        
                        <!-- END: Sales Report -->
                        <!-- BEGIN: Official Store -->
                        
                        <!-- END: Official Store -->
                        <!-- BEGIN: Weekly Best Sellers -->
            
                        <!-- END: Weekly Best Sellers -->
                        <!-- BEGIN: General Report -->
                      
                        <!-- END: General Report -->
                        <!-- BEGIN: Weekly Top Seller -->
                      
                        <!-- END: Weekly Top Seller -->
                    </div>
                    <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-10">
                        <div class="xxl:pl-6 grid grid-cols-12 gap-6">
                           
                            <div class="col-span-12 md:col-span-6 xl:col-span-12 xxl:col-span-12 xl:col-start-1 xl:row-start-1 xxl:col-start-auto xxl:row-start-auto mt-3">
                            <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> 
                    <div class="rounded-md px-5 py-4 mb-2 text-gray-700">
     <div class="flex items-center">
         
        
     </div>
     <div class="mt-3">Welcome onboard to All Nations Full Gospel resource portal. </div>
 </div>
 </div>
                            </div>
                            <!-- END: Important Notes -->
                            <!-- BEGIN: Schedules -->
                   
                            <!-- END: Schedules -->
                        </div>
                    </div>
                </div>
            
@endsection