<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.index')}}" class="ms-1 text-md font-small md:text-lg md:font-medium  text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">SCHEDULES - Management</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5">
            <div x-data="{ 
                activeTab: localStorage.getItem('activeTab') || 'tab1' 
            }" class="md:p-6 text-gray-900 dark:text-gray-100 w-full mt-3">
                 {{-- TABS  --}}
                    <div class="flex space-x-2 border-b overflow-x-auto whitespace-nowrap scrollbar-hide">
                        <button @click="activeTab = 'tab1'; localStorage.setItem('activeTab', 'tab1')"
                            :class="activeTab === 'tab1' ? 'border-red-700 dark:border-gray-300 font-semibold text-lg text-red-900 dark:text-gray-200' : 'border-transparent text-gray-600'"
                            class="px-4 py-2 border-b-2 font-medium focus:outline-none dark:text-gray-400">
                            Centers
                        </button>
                        <button @click="activeTab = 'tab2'; localStorage.setItem('activeTab', 'tab2')"
                            :class="activeTab === 'tab2' ? 'border-red-700 dark:border-gray-300 font-semibold text-lg text-red-900 dark:text-gray-200' : 'border-transparent text-gray-600'"
                            class="px-4 py-2 border-b-2 font-medium focus:outline-none dark:text-gray-400">
                            Dates
                        </button>
                        <button @click="activeTab = 'tab3'; localStorage.setItem('activeTab', 'tab3')"
                            :class="activeTab === 'tab3' ? 'border-red-700 dark:border-gray-300 font-semibold text-lg text-red-900 dark:text-gray-200' : 'border-transparent text-gray-600'"
                            class="px-4 py-2 border-b-2 font-medium focus:outline-none dark:text-gray-400">
                            Time
                        </button>
                        <button @click="activeTab = 'tab4'; localStorage.setItem('activeTab', 'tab4')"
                            :class="activeTab === 'tab4' ? 'border-red-700 dark:border-gray-300 font-semibold text-lg text-red-900 dark:text-gray-200' : 'border-transparent text-gray-600'"
                            class="px-4 py-2 border-b-2 font-medium focus:outline-none dark:text-gray-400">
                            Rooms
                        </button>
                        <button @click="activeTab = 'tab5'; localStorage.setItem('activeTab', 'tab5')"
                            :class="activeTab === 'tab5' ? 'border-red-700 dark:border-gray-300 font-semibold text-lg text-red-900 dark:text-gray-200' : 'border-transparent text-gray-600'"
                            class="px-4 py-2 border-b-2 font-medium focus:outline-none dark:text-gray-400">
                            Sessions
                        </button>
                    </div>
            
                {{-- CONTENT --}}
                <div class="mt-5 pt-1 md:pt-0">
                    <div x-show="activeTab === 'tab1'" class="md:p-4 text-gray-900 dark:text-gray-100 mt-3 rounded-lg">
                        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                            {{-- Test Centers --}}
                        </h1>
                        <p class="mt-1 text-md text-gray-600 dark:text-gray-400  xl:px-5">
                            Test Dates details of USePAT Schedule
                        </p>
                        <div class="flex justify-end px-0 md:px-5 mt-5 md:mt-1">
                            <a href="#" id="addCenterModalButton" data-modal-target="addCenterModal" data-modal-toggle="addCenterModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                                Add Center
                            </a>
                        </div>
                        <div class="xl:px-5 my-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="main-table"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead >
                                        <tr>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                CAMPUS ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                CENTER NAME
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                DESCRIPTION
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                STATUS
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($centers as $center)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                                <td>
                                                    {{ $center->id }}
                                                </td>
                                                <td>
                                                    {{ $center->campusID }}
                                                </td>
                                                <td>
                                                    {{ $center->testCenterName }}
                                                </td>
                                                <td>
                                                    {{ $center->description }}
                                                </td>
                                                <td>
                                                    <div class="flex items-center">
                                                        <div class="h-2.5 w-2.5 rounded-full {{ $center->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                        {{ $center->isActive ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                                    <a href="javascript:void(0)" onclick="openEditCenterModal({{ $center->id }})" data-modal-target="editCenterModal" data-modal-toggle="editCenterModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDeleteCenter({{ $center->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div x-show="activeTab === 'tab2'" class="md:p-4 text-gray-900 dark:text-gray-100 mt-3 rounded-lg">
                        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                            {{-- Test Dates --}}
                        </h1>
                        <p class="mt-1 text-md text-gray-600 dark:text-gray-400  xl:px-5">
                            Test Dates details of USePAT Schedule
                        </p>
                        <div class="flex justify-end px-0 md:px-5 mt-5 md:mt-1">
                            <a href="#" id="addDateModalButton" data-modal-target="addDateModal" data-modal-toggle="addDateModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                                Add Date
                            </a>
                        </div>
                        <div class="xl:px-5 my-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table  id="second-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead >
                                        <tr>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                DATE
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                STATUS
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dates as $date)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                                <td>
                                                    {{ $date->id }}
                                                </td>
                                                <td>
                                                    {{ $date->testDate }}
                                                </td>
                                                <td>
                                                    <div class="flex items-center">
                                                        <div class="h-2.5 w-2.5 rounded-full {{ $date->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                        {{ $date->isActive ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                                    <a href="javascript:void(0)" onclick="openEditDateModal({{ $date->id }})" data-modal-target="editDateModal" data-modal-toggle="editDateModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDeleteDate({{ $date->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div x-show="activeTab === 'tab3'" class="md:p-4 text-gray-900 dark:text-gray-100 mt-3 rounded-lg">
                        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                            {{-- Test Times --}}
                        </h1>
                        <p class="mt-1 text-md text-gray-600 dark:text-gray-400  xl:px-5">
                            Test Time details of USePAT Schedule
                        </p>
                        <div class="flex justify-end px-0 md:px-5 mt-5 md:mt-1">
                            <a href="#" id="addTimeModalButton" data-modal-target="addTimeModal" data-modal-toggle="addTimeModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                                Add Time
                            </a>
                        </div>
                        <div class="xl:px-5 my-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="third-table"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead >
                                        <tr>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                TIME START
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                TIME END
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                START VALUE
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                END VALUE
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                STATUS
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($times as $time)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                                <td>
                                                    {{ $time->id }}
                                                </td>
                                                <td>
                                                    {{ $time->testTimeStartString }}
                                                </td>
                                                <td>
                                                    {{ $time->testTimeEndString }}
                                                </td>
                                                <td>
                                                    {{ $time->testTimeStart }}
                                                </td>
                                                <td>
                                                    {{ $time->testTimeEnd}}
                                                </td>
                                                <td>
                                                    <div class="flex items-center">
                                                        <div class="h-2.5 w-2.5 rounded-full {{ $time->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                        {{ $time->isActive ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                                    <a href="javascript:void(0)" onclick="openEditTimeModal({{ $time->id }})" data-modal-target="editTimeModal" data-modal-toggle="editTimeModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDeleteTime({{ $time->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div x-show="activeTab === 'tab4'" class="md:p-4 text-gray-900 dark:text-gray-100 mt-3 rounded-lg">
                        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                            {{-- Test Rooms --}}
                        </h1>
                        <p class="mt-1 text-md text-gray-600 dark:text-gray-400  xl:px-5">
                            Test Rooms details of USePAT Schedule
                        </p>
                        <div class="flex justify-end px-0 md:px-5 mt-5 md:mt-1">
                            <a href="#" id="addRoomModalButton" data-modal-target="addRoomModal" data-modal-toggle="addRoomModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                                Add Room
                            </a>
                        </div>
                        <div class="xl:px-5 my-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="fourth-table"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead >
                                        <tr>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ROOM
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                DESCRIPTION
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                STATUS
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rooms as $room)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                                <td>
                                                    {{ $room->id }}
                                                </td>
                                                <td>
                                                    {{ $room->testRoomName }}
                                                </td>
                                                <td>
                                                    {{ $room->description }}
                                                </td>
                                                <td>
                                                    <div class="flex items-center">
                                                        <div class="h-2.5 w-2.5 rounded-full {{ $room->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                        {{ $room->isActive ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                                    <a href="javascript:void(0)" onclick="openEditRoomModal({{ $room->id }})" data-modal-target="editRoomModal" data-modal-toggle="editRoomModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDeleteRoom({{ $room->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div x-show="activeTab === 'tab5'" class="md:p-4 text-gray-900 dark:text-gray-100 mt-3 rounded-lg">
                        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                            {{-- Test Sessions --}}
                        </h1>
                        <p class="mt-1 text-md text-gray-600 dark:text-gray-400  xl:px-5">
                            Test Sessions details of USePAT Schedule
                        </p>
                        <div class="flex justify-end px-0 md:px-5 mt-5 md:mt-1">
                            <a href="#" id="addSessionModalButton" data-modal-target="addSessionModal" data-modal-toggle="addSessionModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                                Add Session
                            </a>
                        </div>
                        <div class="xl:px-5 my-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table id="fifth-table"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead >
                                        <tr>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ID
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                SESSION
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                STATUS
                                            </th>
                                            <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sessions as $session)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                                <td>
                                                    {{ $session->id }}
                                                </td>
                                                <td>
                                                    {{ $session->testSessionName }}
                                                </td>
                                                <td>
                                                    <div class="flex items-center">
                                                        <div class="h-2.5 w-2.5 rounded-full {{ $session->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                        {{ $session->isActive ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                                    <a href="javascript:void(0)" onclick="openEditSessionModal({{ $session->id }})" data-modal-target="editSessionModal" data-modal-toggle="editSessionModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDeleteSession({{ $session->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        {{-- MODALS --}}
            @include('Layouts.Modal.ScheduleCenters.Create')
            @include('Layouts.Modal.ScheduleCenters.Edit')
            @include('Layouts.Modal.ScheduleDates.Create')
            @include('Layouts.Modal.ScheduleDates.Edit')
            @include('Layouts.Modal.ScheduleTimes.Create')
            @include('Layouts.Modal.ScheduleTimes.Edit')
            @include('Layouts.Modal.ScheduleRooms.Create')
            @include('Layouts.Modal.ScheduleRooms.Edit')
            @include('Layouts.Modal.ScheduleSessions.Create')
            @include('Layouts.Modal.ScheduleSessions.Edit')
        </div>
    </div>


    @push('scripts')

        {{-- DATATABLES --}}
        <script src="{{ asset('JS/Tables/DatatableGeneric.js') }}"></script>

        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalUnique.js') }}"></script>
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>

        {{-- CENTER TAB --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD CENTER
                var submitFormUrl = "{{ route('scheduleCenters.store') }}";
                document.getElementById('addCenterForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessageCenter').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessageCenter');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

                // AXIOS UPDATE CENTER
                document.getElementById('editCenterForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const centerID = document.getElementById('centerID').value;

                    axios.post(`/admission/schedule/scheduleCenters/${centerID}`, formData)
                        .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessageCenter').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessageCenter');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });



            });
            
            
            // FUNCTION TO SHOW CENTER TO EDIT
            function openEditCenterModal(centerID) {
                axios.get(`/admission/schedule/scheduleCenters/${centerID}/edit`)
                    .then(response => {
                        const center = response.data;
                        document.getElementById('centerID').value = center.id;
                        document.getElementById('e_centerCampus').value = center.campusID;
                        document.getElementById('e_centerCenter').value = center.testCenterName;
                        document.getElementById('e_centerDescription').value = center.description;
                        document.getElementById('e_centerStatus').value = center.isActive;

                    })
                    .catch(error => {
                        console.error('Error fetching center data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }




            // FUNCTION TO DELETE ITEM
            function swalDeleteCenter(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleCenters.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                // location.reload(); 
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                        
                    }
                });
            }

        </script>

        {{-- DATE TAB --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD DATE
                var submitFormUrl = "{{ route('scheduleDates.store') }}";
                document.getElementById('addDateForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessageDate').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessageDate');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

                // AXIOS UPDATE DATE
                document.getElementById('editDateForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const dateID = document.getElementById('dateID').value;

                    axios.post(`/admission/schedule/scheduleDates/${dateID}`, formData)
                        .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessageDate').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessageDate');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });



            });
            
            
            // FUNCTION TO SHOW DATE TO EDIT
            function openEditDateModal(dateID) {
                axios.get(`/admission/schedule/scheduleDates/${dateID}/edit`)
                    .then(response => {
                        const date = response.data;
                        document.getElementById('dateID').value = date.id;
                        document.getElementById('e_dateDate').value = date.testDate;
                        document.getElementById('e_dateStatus').value = date.isActive;

                    })
                    .catch(error => {
                        console.error('Error fetching date data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }




            // FUNCTION TO DELETE ITEM
            function swalDeleteDate(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleDates.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                // location.reload(); 
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                        
                    }
                });
            }


        </script>

        {{-- TIME TAB --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD TIME
                var submitFormUrl = "{{ route('scheduleTimes.store') }}";
                document.getElementById('addTimeForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessageTime').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessageTime');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

                // AXIOS UPDATE TIME
                document.getElementById('editTimeForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const timeID = document.getElementById('timeID').value;

                    axios.post(`/admission/schedule/scheduleTimes/${timeID}`, formData)
                        .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessageTime').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessageTime');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });



            });
            
            
            // FUNCTION TO SHOW TIME TO EDIT
            function openEditTimeModal(timeID) {
                axios.get(`/admission/schedule/scheduleTimes/${timeID}/edit`)
                    .then(response => {
                        const time = response.data;
                        document.getElementById('timeID').value = time.id;
                        document.getElementById('e_time_Start').value = time.testTimeStartString;
                        document.getElementById('e_time_End').value = time.testTimeEndString;
                        document.getElementById('e_start_Value').value = time.testTimeStart;
                        document.getElementById('e_end_Value').value = time.testTimeEnd;
                        document.getElementById('e_timeStatus').value = time.isActive;

                    })
                    .catch(error => {
                        console.error('Error fetching time data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }




            // FUNCTION TO DELETE ITEM
            function swalDeleteTime(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleTimes.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                // location.reload(); 
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                        
                    }
                });
            }


        </script>

        {{-- ROOM TAB --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD ROOM
                var submitFormUrl = "{{ route('scheduleRooms.store') }}";
                document.getElementById('addRoomForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessageRoom').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessageRoom');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

                // AXIOS UPDATE ROOM
                document.getElementById('editRoomForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const roomID = document.getElementById('roomID').value;

                    axios.post(`/admission/schedule/scheduleRooms/${roomID}`, formData)
                        .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessageRoom').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessageRoom');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });



            });
            
            
            // FUNCTION TO SHOW ROOM TO EDIT
            function openEditRoomModal(roomID) {
                axios.get(`/admission/schedule/scheduleRooms/${roomID}/edit`)
                    .then(response => {
                        const room = response.data;
                        document.getElementById('roomID').value = room.id;
                        document.getElementById('e_roomName').value = room.testRoomName;
                        document.getElementById('e_room_description').value = room.description;
                        document.getElementById('e_roomStatus').value = room.isActive;

                    })
                    .catch(error => {
                        console.error('Error fetching room data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }




            // FUNCTION TO DELETE ITEM
            function swalDeleteRoom(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleRooms.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                // location.reload(); 
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                        
                    }
                });
            }


        </script>

        {{-- SESSION TAB --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD SESSION
                var submitFormUrl = "{{ route('scheduleSessions.store') }}";
                document.getElementById('addSessionForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessageSession').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessageSession');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

                // AXIOS UPDATE SESSION
                document.getElementById('editSessionForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const sessionID = document.getElementById('sessionID').value;

                    axios.post(`/admission/schedule/scheduleSessions/${sessionID}`, formData)
                        .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessageSession').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessageSession');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });



            });
            
            
            // FUNCTION TO SHOW SESSION TO EDIT
            function openEditSessionModal(sessionID) {
                axios.get(`/admission/schedule/scheduleSessions/${sessionID}/edit`)
                    .then(response => {
                        const session = response.data;
                        document.getElementById('sessionID').value = session.id;
                        document.getElementById('e_sessionName').value = session.testSessionName;
                        document.getElementById('e_sessionStatus').value = session.isActive;

                    })
                    .catch(error => {
                        console.error('Error fetching session data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }




            // FUNCTION TO DELETE ITEM
            function swalDeleteSession(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleSessions.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                // location.reload(); 
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                        
                    }
                });
            }


        </script>

        <script>
            
            // FUNCTION TO CLOSE ADD MODALS
            function closeAddModal() {
                document.getElementById('addCenterModal').classList.add('hidden');
                document.getElementById('errorMessageCenter').innerHTML = '';
                document.getElementById('addDateModal').classList.add('hidden');
                document.getElementById('errorMessageDate').innerHTML = '';
                document.getElementById('addTimeModal').classList.add('hidden');
                document.getElementById('errorMessageTime').innerHTML = '';
                document.getElementById('addRoomModal').classList.add('hidden');
                document.getElementById('errorMessageRoom').innerHTML = '';
                document.getElementById('addSessionModal').classList.add('hidden');
                document.getElementById('errorMessageSession').innerHTML = '';
            }

            // FUNCTION TO CLOSE EDIT MODALS
            function closeEditModal() {
                document.getElementById('editCenterModal').classList.add('hidden');
                document.getElementById('e_errorMessageCenter').innerHTML = '';
                document.getElementById('editDateModal').classList.add('hidden');
                document.getElementById('e_errorMessageDate').innerHTML = '';
                document.getElementById('editTimeModal').classList.add('hidden');
                document.getElementById('e_errorMessageTime').innerHTML = '';
                document.getElementById('editRoomModal').classList.add('hidden');
                document.getElementById('e_errorMessageRoom').innerHTML = '';
                document.getElementById('editSessionModal').classList.add('hidden');
                document.getElementById('e_errorMessageSession').innerHTML = '';
            }
        </script>

    @endpush

</x-Main-layout>

