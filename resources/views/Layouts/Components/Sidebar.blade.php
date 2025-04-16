
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <div class="py-4 px-1  overflow-y-auto">
            {{-- <img src="{{asset('img_assets/usep.png') }}" class="mx-auto w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full shadow-lg " alt="Student Photo"> --}}
            <div id="alertSidebar" class="p-4  rounded-lg bg-blue-50 dark:bg-blue-900" role="alert">
                <div class="flex items-center mb-3">
                    <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-900">Welcome</span>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-400 dark:hover:bg-blue-800" data-dismiss-target="#alertSidebar" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-blue-800 dark:text-blue-400">
                    {{ Auth::user()->name }}
                </p>
                <p class="mb-2 flex text-xs text-blue-800 dark:text-blue-400">
                    {{ Auth::user()->email }}
                </p>
                {{-- <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Try new feature</a> --}}
            </div>

            @if(!Auth::user()->force_pass)
                <ul class="space-y-3 mt-8 font-medium">
                    <li>
                        <x-Nav-Link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"  fill="currentcolor" >
                                <path d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160Zm-400 0h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z"/>
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </x-Nav-Link>
                    </li>
                    {{-- <li>
                        <button type="button" class="flex items-center w-full p-2 px-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:text-white hover:bg-red-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-rfids" data-collapse-toggle="dropdown-rfids">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">RFID</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-rfids" class="hidden mx-1 p-2 mt-1 space-y-2 rounded-xl bg-slate-100 dark:bg-slate-800">
                            <li >
                                <x-subNav-Link :href="route('rfid.dashboard')" :active="request()->routeIs('rfid.dashboard')">
                                    <span class="ms-3">Dashboard</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('studentsRFIDs.index')" :active="request()->routeIs('studentsRFIDs.index')">
                                    <span class="ms-3">Students</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('employeesRFIDs.index')" :active="request()->routeIs('employeesRFIDs.index')">
                                    <span class="ms-3">Employees</span>
                                </x-subNav-Link>
                            </li>
                        </ul> --}}
                    </li>
                    {{-- <li>
                        <x-Nav-Link :href="route('registers.index')" :active="request()->routeIs('registers.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Registrations</span>
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">31</span>
                        </x-Nav-Link>
                    </li> --}}
                    {{-- <li>
                        <button type="button" class="flex items-center w-full p-2 px-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:text-white hover:bg-red-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-registrations" data-collapse-toggle="dropdown-registrations">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Registrations</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-registrations" class="hidden mx-1 p-2 mt-1 space-y-2 rounded-xl bg-slate-100 dark:bg-slate-800">
                            <li >
                                <x-subNav-Link :href="route('registrations.pdf.USePAT')" :active="request()->routeIs('registrations.pdf.USePAT')">
                                    <span class="ms-3">USePAT</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('registrations.pdf.USePATv2')" :active="request()->routeIs('registrations.pdf.USePATv2')">
                                    <span class="ms-3">USePAT V2</span>
                                </x-subNav-Link>
                            </li>
                        </ul>
                    </li> --}}
                    <li x-data="{
                            open: false,
                            isActive: window.location.pathname.includes('/admission/schedule/scheduleSlots') ||
                                    window.location.pathname.includes('/admission/schedule/scheduleApplicants') ||
                                    window.location.pathname.includes('/admission/schedule/scheduleManagements') ||
                                    window.location.pathname.includes('/admission/schedule/scheduleReschedules'),
                            init() {
                                if (this.isActive) {
                                    this.open = true;
                                }
                            }
                        }">
                        <button type="button"
                            class="flex items-center w-full p-2 px-2 text-base text-gray-900 transition duration-75 rounded-lg group"
                            :class="{'bg-red-800 text-white dark:bg-red-900': isActive, 'hover:bg-slate-200 hover:text-slate-800  dark:text-white dark:hover:bg-gray-700 ': !isActive}"
                            aria-controls="dropdown-schedules"
                            @click="open = !open">

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Schedules</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <ul id="dropdown-schedules" x-show="open"  class="mx-1 p-2 mt-1 space-y-2 rounded-xl bg-slate-100 dark:bg-gray-900 dark:bg-opacity-40">
                            <li>
                                <x-subNav-Link :href="route('schedules.applicants')" :active="request()->routeIs('schedules.applicants')">
                                    <span class="ms-3">Applicants</span>
                                </x-subNav-Link>
                            </li>
                            <li>
                                <x-subNav-Link :href="route('schedules.management')" :active="request()->routeIs('schedules.management')">
                                    <span class="ms-3">Management</span>
                                </x-subNav-Link>
                            </li>
                            <li>
                                <x-subNav-Link :href="route('scheduleSlots.index')" :active="request()->routeIs('scheduleSlots.index')">
                                    <span class="ms-3">Slots</span>
                                </x-subNav-Link>
                            </li>
                            <li>
                                <x-subNav-Link :href="route('scheduleReschedules.index')" :active="request()->routeIs('scheduleReschedules.index')">
                                    <span class="ms-3">Reschedule</span>
                                </x-subNav-Link>
                            </li>
                        </ul>
                    </li>

                    <li x-data="{
                            open: false,
                            isActive: window.location.pathname.includes('/admission/result/dashboard') ||
                                    window.location.pathname.includes('/admission/result/overall') ||
                                    window.location.pathname.includes('/admission/result/qualified') ||
                                    window.location.pathname.includes('/admission/result/notQualified') ||
                                    window.location.pathname.includes('/admission/result/transferees'),
                            init() {
                                if (this.isActive) {
                                    this.open = true;
                                }
                            }
                        }">
                        <button type="button"
                            class="flex items-center w-full p-2 px-2 text-base text-gray-900 transition duration-75 rounded-lg group"
                            :class="{'bg-red-800 text-white dark:bg-red-900': isActive, 'hover:bg-slate-200 hover:text-slate-800  dark:text-white dark:hover:bg-gray-700': !isActive}"
                            aria-controls="dropdown-results"
                            @click="open = !open">

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Results</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <ul id="dropdown-results" x-show="open"  class="mx-1 p-2 mt-1 space-y-2 rounded-xl bg-slate-100 dark:bg-gray-900 dark:bg-opacity-40">
                            <li >
                                <x-subNav-Link :href="route('results.index')" :active="request()->routeIs('results.index')">
                                    <span class="ms-3">Dashboard</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('results.overall')" :active="request()->routeIs('results.overall')">
                                    <span class="ms-3">Overall Ranking</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('results.qualified')" :active="request()->routeIs('results.qualified')">
                                    <span class="ms-3">Qualified</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('results.notQualified')" :active="request()->routeIs('results.notQualified')">
                                    <span class="ms-3">Not Qualified</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('results.transferees')" :active="request()->routeIs('results.transferees')">
                                    <span class="ms-3">Transferees</span>
                                </x-subNav-Link>
                            </li>
                        </ul>
                    </li>
                    {{-- <li>
                        <button type="button" class="flex items-center w-full p-2 px-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:text-white hover:bg-red-800 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-courseEvals" data-collapse-toggle="dropdown-courseEvals">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z"/>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Course Evaluation</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <ul id="dropdown-courseEvals" class="hidden mx-1 p-2 mt-1 space-y-2 rounded-xl bg-slate-100 dark:bg-slate-800">
                            <li >
                                <x-subNav-Link :href="route('courseEvals.index')" :active="request()->routeIs('courseEvals.index')">
                                    <span class="ms-3">Form</span>
                                </x-subNav-Link>
                            </li>
                            <li >
                                <x-subNav-Link :href="route('courseEvalParameters.index')" :active="request()->routeIs('courseEvalParameters.index')">
                                    <span class="ms-3">Management</span>
                                </x-subNav-Link>
                            </li>
                        </ul>
                    </li> --}}
                    @if(Auth::user()->type)
                        <li>
                            <x-Nav-Link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                    <path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/>
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                            </x-Nav-Link>
                        </li>
                    @endif
                </ul>    
            @endif

                <ul class="space-y-3 mt-8 font-medium border-t border-gray-200 dark:border-gray-700">
                    <li>
                        <x-Nav-Link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentcolor">
                                <path d="M580-40q-25 0-42.5-17.5T520-100v-280q0-25 17.5-42.5T580-440h280q25 0 42.5 17.5T920-380v280q0 25-17.5 42.5T860-40H580Zm0-60h280v-32q-25-31-61-49.5T720-200q-43 0-79 18.5T580-132v32Zm140-140q25 0 42.5-17.5T780-300q0-25-17.5-42.5T720-360q-25 0-42.5 17.5T660-300q0 25 17.5 42.5T720-240ZM480-480Zm2-140q-58 0-99 41t-41 99q0 48 27 84t71 50v-90q-8-8-13-20.5t-5-23.5q0-25 17.5-42.5T482-540q14 0 25 5.5t19 14.5h90q-13-44-49.5-72T482-620ZM370-80l-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-85 65H696q-1-5-2-10.5t-3-10.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q24 25 54 42t65 22v184h-70Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
                        </x-Nav-Link>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-Nav-Link :active="request()->routeIs('logout')" :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">

                                <svg fill="currentcolor" class="flex-shrink-0 w-5 h-5 transition duration-75   dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" >
                                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/>
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Sign Out</span>
                            </x-Nav-Link>
                        </form>
                    </li>
                </ul>

            <img src="{{asset('img_assets/AdmissionLogo.png') }}" class="mx-auto w-full my-5" alt="Logo">
        </div>

    </div>

</aside>
