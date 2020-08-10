@extends('layouts.userinter')
@section('title')
    <title> User | Sermons  </title>
@endsection
@section('content')


                <!-- BEGIN: Top Bar -->
                <div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">User</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Verification</a> </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                    <div class="search hidden sm:block">
                        </div>
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
                <br/>
               


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
                   Hi, {{ ucwords(Auth::user()->name) }}
                </h2>
<br/>
<form method="POST" action="{{route('sermons.postallow')}}">
{{ csrf_field() }} 
                
                <div class="grid grid-cols-12 gap-6 mt-5">

               
                       
                   
                    <!-- BEGIN: Data List -->


                    
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

                    
                  <div class="rounded-md px-5 py-4 mb-2  text-white" style="background-color:#fff">
 
                  <div class="rounded-md flex items-center px-5 py-4 mb-2 bg-theme-18 text-theme-9"> <i data-feather="alert-triangle" class="w-6 h-6 mr-2"></i> 
                    <div class="rounded-md px-5 py-4 mb-2 text-gray-700">
     <div class="flex items-center">
         <div class="font-medium text-lg">Your account have been created successfuly</div>
        
     </div>
     <div class="mt-3">Welcome onboard to All Nations Full Gospel resource portal. Your account will be approved after verification</div>
 </div>
 </div>


</div>
     
                  
            
                   
                   
                        
                   
                   

                   
                    </form>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                
                    <!-- END: Pagination -->
                </div>
                <!-- BEGIN: Delete Confirmation Modal -->
               
                <!-- END: Delete Confirmation Modal -->
            
@endsection

