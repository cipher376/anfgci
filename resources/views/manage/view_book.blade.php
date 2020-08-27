<?php   use \App\Http\Controllers\ManageController; ?>
<?php   use \App\Http\Controllers\PastorController; ?>
@extends('layouts.manage')
@section('content')

<?php $countries=ManageController::showCountries() ?>
<!-- BEGIN: Top Bar -->
<div class="top-bar">
    @foreach($books as $book)
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Administration</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Book</a> </div>
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
                   Book Information
                </h2>
            </div>
                

                
                            

         <div class="intro-y box py-10 sm:py-8 mt-5">
             
             <form method="POST" action="" enctype="multipart/form-data">
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
                                                     <img id="blah" alt="" class="rounded-md" src="<?php echo PastorController::showbookCover($book->id); ?>">
                                    
                                                                                                   </div>
                                                    
                                                 </div>
                                             </div>
                                             <div class="col-span-12 xl:col-span-8"><h2 style="font-size:20px">  {{ $book->title }}</h2>
                                          <span style="font-size:13px"><b>Author </b>  {{ $book->artist }}</span>
                                          <br/>
                                        
                                          <?php echo stripslashes(ucfirst($book->note)); ?>
<br/><br/>
                                         

                                  <?php if($book->bookType=='Free'){?>
                                    <span class="text-xs px-1 rounded-full bg-theme-12 text-white mr-1" style="padding:5px">{{ucwords($book->bookType)}}</span> 
                                <?php } else{?>
                                
                                    <span class="text-xs px-1 rounded-full bg-theme-9 text-white mr-1" style="padding:5px">{{ucwords($book->bookType)}}</span>
                                <?php }?>
                                            <br/>  <br/>  <br/>
                                           
                                             <a href="/manage/book" class="button text-white bg-theme-11 shadow-md mr-2">Go back to list </a>
              
                                        </div>
                                         </div>
                                         
         
         



                                         

                   
                   
                </div>
         
         
                                         
                                     </div>

                                     
                                  
                                                         
                                 </div>








             </form>
             @endforeach
            </div>
@endsection