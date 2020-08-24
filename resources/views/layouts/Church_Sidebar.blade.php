<?php   use \App\Http\Controllers\ManageController;

$right= ManageController::right($church->churchID );?>
<div class="intro-y box mt-5">
                            
                            <div class="p-5 border-t border-gray-200">
                                <a class="flex items-center mt-5" href="/manage/churches/view/{{ $church->churchID }}"> <i data-feather="slack" class="w-4 h-4 mr-2"></i> Information </a>
                                <a class="flex items-center mt-5" href="/manage/churches/view/album/{{ $church->churchID }}"> <i data-feather="image" class="w-4 h-4 mr-2"></i> Photo Album </a>
                                <a class="flex items-center mt-5" href="/manage/church/services/{{$church->churchID }}"> <i data-feather="package" class="w-4 h-4 mr-2"></i> Services </a>
                                <a class="flex items-center mt-5" href="/manage/church/events/{{$church->churchID }}"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Events </a>
                            </div>
                            <div class="p-5 border-t border-gray-200">
                                <a class="flex items-center mt-5" href="/manage/churches/{{$church->churchID}}/reports"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Reports </a>
                               <?php if($right==1){?>
                                <a class="flex items-center mt-5" href="/manage/church/user_settings/{{$church->churchID }}"> <i data-feather="key" class="w-4 h-4 mr-2"></i> Add/Rights settings </a>
                                <a class="flex items-center mt-5" href="/manage/church/{{$church->churchID}}/pastors"> <i data-feather="user-plus" class="w-4 h-4 mr-2"></i> Pastors Incharge </a>
                               <?php }?>
                            </div>
                           
                        </div>