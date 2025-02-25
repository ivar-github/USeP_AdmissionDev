<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('results.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">RESULTS - Dashboard</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            <div id="displayGraphs" class="justify-center items-center place-items-center grid lg:grid-cols-2 grid-cols-1 lg:px-2 gap-5 lg:gap-5 xl:gap-10">
                <x-Graphs.ResultVerticalBar />
                <x-Graphs.ResultAreaChart />
            </div>
            <div id="displayGraphs" class="py-10 justify-center items-center place-items-center grid lg:grid-cols-2 grid-cols-1 lg:px-2 gap-5 lg:gap-5 xl:gap-10">
                <x-Graphs.ResultLineChart />
                <x-Graphs.ResultHorizontalBar />
            </div>
        </div>
    </div>

</x-Main-layout>

