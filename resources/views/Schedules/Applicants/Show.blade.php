<x-Main-layout>
    @if (session('success'))
        <x-Alert-success>
            {{ session('success') }}
        </x-Alert-success>
    @endif
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
        <x-breadcrumbs>
            <a  href="{{route('employees.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">EMPLOYEES</a>
        </x-breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-2">
                <div class="px-2 md-px-10 pt-5 mx-auto max-w-lg">
                    <h1 class="text-2xl text-center bg-red-800 mb-5 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Employee's Details
                    </h1>
                </div>
                <div class=" max-w-md mx-auto m-5  bg-white border border-gray-200 rounded-xl shadow-xl dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-end px-2 pt-2">
                        <a href="{{ route('employees.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-400 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="currentcolor">
                                <path d="M440-560q33 0 56.5-23.5T520-640q0-33-23.5-56.5T440-720q-33 0-56.5 23.5T360-640q0 33 23.5 56.5T440-560Zm0 160q45 0 84.5-19t68.5-54q-35-23-73.5-35T440-520q-41 0-79.5 12T287-473q29 35 68.5 54t84.5 19Zm384 280L636-308q-41 32-90.5 50T440-240q-134 0-227-93t-93-227q0-134 93-227t227-93q134 0 227 93t93 227q0 56-18 105.5T692-364l188 188-56 56ZM440-320q100 0 170-70t70-170q0-100-70-170t-170-70q-100 0-170 70t-70 170q0 100 70 170t170 70Zm0-240Z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="flex flex-col items-center pb-8 px-5 md:px-10">
                        <img src="{{ $employee->Photo ? $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo) : asset('img_assets/avatar.png') }}" class=" w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full shadow-xl ring-1 ring-gray-300 mx-auto" alt="Student Photo">
                        <h6 class="mb-1 text-lg font-medium text-gray-900 dark:text-white">
                            {{ $employee->EmployeeID }}
                        </h6>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                            {{ $employee->Prefix }} {{ $employee->LastName }}, {{ $employee->FirstName }} {{ $employee->MiddleName }}
                        </h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $employee->Email }}
                        </span>
                        <div class="w-full mt-10 mx-2 ">
                            <div class="relative">
                                <input type="number" name="smartID" value="{{ $employee->SmartCardID }}" id="smartID" class="block px-2.5 p-4 w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " disabled/>
                                <label for="smartID" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">SmartCard ID</label>
                            </div>
                        </div>
                        <div class="flex mt-4 md:mt-6">
                            @if(session('success'))
                                <a href="{{ route('employees.index')}}" class="inline-flex items-center px-8 py-2 text-sm font-medium text-center shadow-lg text-gray-200  bg-blue-800 hover:bg-blue-700 hover:text-gray-200 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800">DONE</a>
                            @else
                                <a href="{{ route('employees.edit', $employee->EmployeeID)}}" class="inline-flex items-center px-8 py-2 text-sm font-medium text-center shadow-lg text-gray-200  bg-blue-800 hover:bg-blue-700 hover:text-gray-200 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus:ring-blue-800">EDIT</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>
