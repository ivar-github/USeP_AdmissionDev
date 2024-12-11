<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('profile.edit')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">PROFILE</a>
    </x-Breadcrumbs>
    {{-- <hr class="mt-5 max-w-40"> --}}
    <div class="mx-auto h-full">
        <div class="py-10 px-2">
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
