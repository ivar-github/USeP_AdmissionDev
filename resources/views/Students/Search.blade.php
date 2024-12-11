{{-- <x-Main-layout>
    <div class="py-5 ">
        <x-breadcrumbs>
            <a  href="{{route('students.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">STUDENTS</a>
        </x-breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-2">
                <div class="px-2 md-px-10 pt-5 mx-auto max-w-lg">
                    <h1 class="text-2xl text-center bg-red-800 mb-5 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Student's Details
                    </h1>
                </div>
                <div class=" max-w-md mx-auto m-5  bg-white border border-gray-200 rounded-xl shadow-xl dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-end px-2 pt-2">
                        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-400 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="currentcolor">
                                <path d="M440-560q33 0 56.5-23.5T520-640q0-33-23.5-56.5T440-720q-33 0-56.5 23.5T360-640q0 33 23.5 56.5T440-560Zm0 160q45 0 84.5-19t68.5-54q-35-23-73.5-35T440-520q-41 0-79.5 12T287-473q29 35 68.5 54t84.5 19Zm384 280L636-308q-41 32-90.5 50T440-240q-134 0-227-93t-93-227q0-134 93-227t227-93q134 0 227 93t93 227q0 56-18 105.5T692-364l188 188-56 56ZM440-320q100 0 170-70t70-170q0-100-70-170t-170-70q-100 0-170 70t-70 170q0 100 70 170t170 70Zm0-240Z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col items-center pb-8 px-5 md:px-10">
                        <img src="{{ $student->StudentPicture ? $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture) : asset('img_assets/avatar.png') }}" class=" w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full  shadow-xl ring-1 ring-gray-300 mx-auto" alt="Student StudentPicture">
                        <h6 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">
                            {{ $student->StudentNo }}
                        </h6>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                            {{ $student->LastName }}, {{ $student->FirstName }} {{ $student->Middlename }}
                        </h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $student->Email }}
                        </span>
                        <div class="w-full mt-10 mx-2 ">
                            <div class="relative">
                                <input type="number" name="smartID" value="{{ $student->SmartCardID }}" id="smartID" class="block px-2.5 p-4 w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " disabled/>
                                <label for="smartID" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">SmartCard ID</label>
                            </div>
                        </div>
                        <div class="flex mt-4 md:mt-6">
                                <a href="{{ route('students.edit', $student->StudentNo)}}" class="inline-flex items-center px-8 py-2 text-sm font-medium text-center shadow-lg text-gray-200  bg-blue-800 hover:bg-blue-700 hover:text-gray-200 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800">EDIT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout> --}}
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
            <a  href="{{route('students.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">STUDENTS</a>
        </x-Breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg  py-10 px-2">
                <div class="px-2 md-px-10 mx-auto max-w-lg py-10 rounded-xl shadow-1xl">
                    <h1 class="text-2xl text-center bg-red-800 mb-10 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Search Student
                    </h1>
                    <x-Validation-error :messages="session('notfound')" class="mt-2" />
                    <form method="POST" action="{{ route('students.search')}}">
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
                            @if ($students->isEmpty())
                                <p class="text-center font-semibold text-gray-700 dark:text-gray-100">No Student Found!!</p>
                            @else
                                <ul class="max-w-md divide-y py-2  divide-gray-200 dark:divide-gray-700 mx-auto justify-center justify-items-center justify-self-center">
                                    @foreach ($students as $student)
                                        <li class=" justify-content mx-auto  ">
                                            <div class="flex items-center py-2 space-x-4 rtl:space-x-reverse ">

                                                <div class="flex-shrink-0">
                                                    {{-- <img src="{{ $student->StudentPicture ? $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture) : asset('img_assets/avatar.png') }}" class="w-10 h-10 rounded-full" alt="Student StudentPicture"> --}}
                                                    <img class="w-16 h-16 rounded-full" src="{{ $student->StudentPicture_base64 ? $student->StudentPicture_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">
                                                        {{ $student->StudentNo }}
                                                    </p>
                                                    <p class="text-md font-medium text-gray-900 truncate dark:text-gray-300">
                                                        {{ $student->LastName }}, {{ $student->FirstName }} {{ $student->Middlename }}
                                                    </p>
                                                    <p class="text-sm font-italic text-gray-500 truncate dark:text-gray-400">
                                                       RFID # : {{ $student->SmartCardID }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <a href="{{ route('students.show', $student->StudentNo)}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                                    </a>
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

