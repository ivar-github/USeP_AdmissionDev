<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-2">
        <div class="p-6 md:p-10 text-gray-900 dark:text-gray-100  ">
            
        <h1 class="text-3xl font-medium text-gray-900 dark:text-gray-100">
            {{ __('Student List') }}
        </h1>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
            <div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg border-2">
                <div class="flex items-center justify-center md:justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 p-3 bg-red-900 dark:bg-gray-900">

                </div>

                {{$slot}}

            </div>
        </div>
    </div>
</div>


@push('scripts')

    {{-- <script>


    </script> --}}

@endpush
