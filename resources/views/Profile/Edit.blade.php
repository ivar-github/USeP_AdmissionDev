<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('profile.edit')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">PROFILE</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            @if (session('force_change'))
                <div x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    id="dropdown-cta" 
                    class="p-4  rounded-lg bg-red-50 dark:bg-red-900 my-2 mx-auto " role="alert">
                        <div class="flex items-center mb-2">
                            <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-orange-200 dark:text-orange-900">WARNING</span>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 inline-flex justify-center items-center w-6 h-6 text-red-900 rounded-lg focus:ring-2 focus:ring-red-400 p-1 hover:bg-red-200 dark:bg-red-900 dark:text-red-400 dark:hover:bg-red-800" data-dismiss-target="#dropdown-cta" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mb-1 text-md text-red-800 dark:text-red-400 ms-3">
                            You are required to change your password before proceeding.                    
                        </p>
                </div>
            @endif
            <div class="flex flex-col lg:flex-row justify-between">
                @if(Auth::user()->type)
                    <div class="mx-auto px-4 sm:p-8 dark:bg-gray-800 rounded-xl border-2 border-dashed py-10 dark:border-gray-500 w-full max-w-3xl min-h-full me-2 lg:mb-0 mb-2">
                        <div class="h-full w-full ">
                            @include('profile.partials.Update-Info')
                        </div>
                    </div>
                @endif
                    <div class="mx-auto px-4 sm:p-8 dark:bg-gray-800 rounded-xl border-2 border-dashed py-10 dark:border-gray-500 w-full max-w-3xl min-h-full ">
                        <div class="h-full w-full ">
                            @include('profile.partials.Update-Password')
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-Main-layout>


