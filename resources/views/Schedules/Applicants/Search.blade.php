<x-Main-layout>
    @if ($errors->any())
        <x-Alert-error>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-Alert-error>
    @endif
    <div class="py-5 ">
        <x-Breadcrumbs>
            <a  href="{{route('employees.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">EMPLOYEES</a>
        </x-Breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg  py-10 px-2">
                <div class="px-2 md-px-10 mx-auto max-w-lg py-10 rounded-xl shadow-1xl">
                    <h1 class="text-2xl text-center bg-red-800 mb-10 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Search Employee
                    </h1>
                    <x-Validation-error :messages="session('notfound')" class="mt-2" />
                    <form method="POST" action="{{ route('employees.search')}}">
                        @csrf
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" value="{{old('rfid', $search )}}" name="rfid" id="rfid" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Employee's ID or Name" required />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                    <div class="relative overflow-x-auto mt-5">
                        <div class="p-5 ">
                            @if ($applicants->isEmpty())
                                <p class="text-center font-semibold text-gray-700 dark:text-gray-100">No Employee Found!!</p>
                            @else
                                <ul class="max-w-md divide-y py-2  divide-gray-200 dark:divide-gray-700 mx-auto justify-center justify-items-center justify-self-center">
                                    @foreach ($applicants as $applicant)
                                        <li class=" justify-content mx-auto  ">
                                            <div class="flex items-center py-2 space-x-4 rtl:space-x-reverse ">

                                                <div class="flex-shrink-0">
                                                    <img class="w-10 h-10 rounded-full" src="{{ $applicant->Photo_base64 ? $applicant->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">
                                                        {{ $applicant->appNo }}
                                                    </p>
                                                    <p class="text-md font-medium text-gray-900 truncate dark:text-gray-300">
                                                        {{ $applicant->testScheduleCode }} {{ $applicant->testCenterID }}, {{ $applicant->testDateID }} {{ $applicant->testTimeID }}
                                                    </p>
                                                    <p class="text-sm font-italic text-gray-500 truncate dark:text-gray-400">
                                                       RFID # : {{ $applicant->termID }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    {{-- <a href="{{ route('scheduleApplicants.show', $applicant->id)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                                    </a> --}}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    @endpush

</x-Main-layout>

