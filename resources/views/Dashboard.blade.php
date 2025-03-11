<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('dashboard')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">DASHBOARD</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class=" dark:bg-gray-800 py-10 overflow-hidden shadow-sm sm:rounded-lg flex justify-center ">
            <div class="lg:px-10 px-2 py-10 text-gray-900 dark:text-gray-100 w-full">
                {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center ">
                    <div class="flex justify-center items-center w-full">
                        <x-RFIDs.EmployeeGraph />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-RFIDs.StudentGraph />
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center my-2">
                    <div class="flex justify-center items-center w-full">
                        <x-RFIDs.EmployeeGenderPie />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-RFIDs.StudentGenderPie />
                    </div>
                </div> --}}
                {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-items-center my-2">
                    <div class="flex justify-center items-center w-full">
                        <x-OverallRFIDGraph />
                    </div>
                    <div class="flex justify-center items-center w-full">
                        <x-OverallRFIDLine />
                    </div>
                </div> --}}
                <div id="displayGraphs" class="justify-center items-center place-items-center grid lg:grid-cols-2 grid-cols-1 lg:px-2 gap-5 lg:gap-5 xl:gap-10">
                    <x-Graphs.ResultVerticalBar />
                    <x-Graphs.ResultAreaChart />
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>

