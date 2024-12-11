<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('dashboard')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">DASHBOARD</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class=" dark:bg-gray-800 py-10 overflow-hidden shadow-sm sm:rounded-lg flex justify-center ">
            <div class="lg:px-10 px-2 py-10 text-gray-900 dark:text-gray-100 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center ">
                    <div class="flex justify-center items-center w-full">
                        <x-EmployeeGraph />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-StudentGraph />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center my-2">
                    <div class="flex justify-center items-center w-full">
                        <x-EmployeeGenderPie />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-StudentGenderPie />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center my-2">
                    <div class="flex justify-center items-center w-full">
                        <x-OverallRFIDGraph />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-OverallRFIDLine />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>

