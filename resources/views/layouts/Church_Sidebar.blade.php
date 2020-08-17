<div class="intro-y box mt-5">
                            
                            <div class="p-5 border-t border-gray-200">
                                <a class="flex items-center mt-5" href="/manage/churches/view/{{ $church->churchID }}"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Church Information </a>
                                <a class="flex items-center mt-5" href="/manage/churches/view/album/{{ $church->churchID }}"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Photo Album </a>
                                <a class="flex items-center mt-5" href="/manage/church/services/{{$church->churchID }}"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Church Services </a>
                                <a class="flex items-center mt-5" href="/manage/church/events/{{$church->churchID }}"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Events </a>
                            </div>
                            <div class="p-5 border-t border-gray-200">
                                <a class="flex items-center mt-5" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Reports </a>
                                <a class="flex items-center mt-5" href="/manage/church/user_settings/{{$church->churchID }}"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> User settings </a>
                                <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Pastors Incharge </a>
                              </div>
                           
                        </div>