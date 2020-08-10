@extends('layouts.pastor')
@section('content')


<!-- BEGIN: Top Bar -->
<div class="top-bar">
@foreach($sermons as $sermon)
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Pastor</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Sermon</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i>{{ strip_tags(htmlspecialchars_decode(substr($sermon->title, 0,70) ))}}...</div>
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
                    </div>      <!-- END: Notifications -->
                   
                </div>
                <!-- END: Top Bar -->




                
                <div class="flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Edit Sermon
                    </h2>

                   
                    
             
                </div>
                

                
               

       
                           <div class="grid grid-cols-12 gap-6 mt-5">
                    <!-- BEGIN: Simple Editor -->
                   
                    <!-- END: Simple Editor -->
                    <!-- BEGIN: Standard Editor -->
                   
                    <!-- END: Standard Editor -->
                    <!-- BEGIN: Fully Featured -->
                   
                    <!-- END: Fully Featured -->
                </div>





                <div class="intro-y box py-10 sm:py-8 mt-5">
             
                <div class="px-5 sm:px-20 mt-10 pt-3 border-gray-200">
                  
                  <form   method="POST" action="{{ route('serm.update',$sermon->sermonID) }}" enctype="multipart/form-data">  
                  {{ method_field("PUT")}}
                 
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
                  
                  <div class="grid grid-cols-12 gap-4 row-gap-5 mt-5">

                  {{ csrf_field() }} 

                        
                    <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="mb-2">Topic</div>
                            <input name="topic" type="text" class="input w-full border flex-1" placeholder="Sermon Topic" value="{{ ucfirst($sermon->title) }}">
                            </div>


                        <div class="intro-y col-span-12 sm:col-span-6">
                            <div class="mb-2">Author</div>
                            <input name="author" type="text" class="input w-full border flex-1" placeholder="Name of minister" value="{{ ucwords($sermon->title) }}">
                           
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-12">
                        <div class="mb-2">Sermon</div>
                        <textarea data-feature="basic" class="summernote" name="sermon">  <?php echo stripslashes($sermon->note); ?></textarea> 
 
                        </div>

                        <div class="intro-y col-span-12 sm:col-span-12">
                            
                        <div class="mb-6" ><b>Uploaded File:</b><span style="color:blue"> {{ ucwords($sermon->url) }}</span></div>
                            
                       </div>

                        
                        <div class="intro-y col-span-12 sm:col-span-6">

                        <div class="mb-6">Upload Sermon PDF file here</div>
                            
                        <input name="file" type="file"   /> </div>
    

                       
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                           
                            <button class="button w-40 justify-center block bg-theme-1 text-white ml-2">Save Sermon</button>
                        </div>
                    </div>
                </div></form>
            </div>
            @endforeach
@endsection