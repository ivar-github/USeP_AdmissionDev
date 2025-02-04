<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('scheduleApplicants.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">SCHEDULES</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="py-10 px-2">
            <div class="px-2 md-px-10 mx-auto max-w-lg py-10 ">
                <h1 class="text-2xl text-center bg-red-800 mb-10 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                    Search Applicants
                </h1>
                <x-Validation-error :messages="session('notfound')" class="mt-2" />
                <form method="POST" action="{{ route('scheduleApplicants.search')}}">
                    @csrf

                    <div class="dark:text-gray-200 mx-2 mb-2">
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
                        <input type="text" name="applicant" id="applicant" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Applicant's No. or Name" required />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-Main-layout>
