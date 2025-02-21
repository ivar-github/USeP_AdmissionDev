<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('scheduleApplicants.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">SCHEDULES</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- CONTENT --}}
                <div class="flex flex-col xl:flex-row boorder gap-4 rounded-lg">
                    {{-- LEFT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-2xl lg:text-3xl font-extrabold tracking-tight ">Search Examinee</h1>
                            <hr class="mb-3">
                            <form method="POST" action="{{ route('scheduleApplicants.search')}}">
                                @csrf
                                <div class="dark:text-gray-200   mb-2">
                                    <label for="termID" class="block text-md text-gray-700  dark:text-gray-300">Term </label>
                                    <select id="termID" name="termID" onchange="getDataByTerm()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @foreach ($terms as $term)
                                            <option value="{{ $term->TermID }}">({{ $term->TermID }}) &nbsp; {{ $term->AcademicYear }} &nbsp;&nbsp;{{ $term->SchoolTerm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text"   name="applicant" id="applicant" class="block w-full p-3 ps-10 text-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Applicant's No. or Name" required />
                                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-1 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                                </div>
                            </form>
                            <div class="relative overflow-x-auto mt-4">
                                <div class="py-2">
                                </div>
                            </div>
                        </div>
                    </div>
                
                    {{-- RIGHT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-xl lg:text-3xl font-extrabold tracking-tight ">Examination Details</h1>
                            <hr class="mb-3">
                            <div class="grid grid-cols-1 gap-3 mt-3">
                                <div class="text-gray-900 space-y-2">
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">App-No. :</p>
                                        <p id="i_appno" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Name :</p>
                                        <p id="i_name" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Date:</p>
                                        <p id="i_date" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Time:</p>
                                        <p id="i_time" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Center:</p>
                                        <p id="i_center" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Room:</p>
                                        <p id="i_room" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Code:</p>
                                        <p id="i_code" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                            <form method="POST" id="editExamineeSchedForm">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" id="applicantID" name="applicantID">

                                <input type="hidden" id="e_term" name="Term">
                                <input type="hidden" id="e_center" name="Center">
                                <input type="hidden" id="e_date" name="Date">
                                <input type="hidden" id="e_time" name="Time">
                                <input type="hidden" id="e_room" name="Room">
                                <input type="hidden" id="e_session" name="Session">
                
                                <div id="e_errorMessage" class="mt-4 text-red-500">
                                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                                <div class="grid grid-cols-1 mt-5 gap-4">
                                    <div class="dark:text-gray-200   mb-2">
                                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Select Test Center:</p>
                                        <select  id="centerID" onchange="getAvaliableSchedByCenter()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            @foreach ($testCenters as $testCenter)
                                                <option value="{{ $testCenter->id }}">{{ $testCenter->testCenterName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-gray-800 dark:text-white dark:text-gray-200 ">
                                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Select Available Schedules:</p>
                                        <div class="flex items-center gap-2">
                                            <x-Input-Dropdown name="Slots" id="e_slots" onchange="selectSchedDetails()"></x-Input-Dropdown>
                                            <button type="button" onclick="refreshAvailableScheds()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="flex items-center">
                                    <x-Input-Submit class="mt-4">Update</x-Input-Submit>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
    </div>
</x-Main-layout>
