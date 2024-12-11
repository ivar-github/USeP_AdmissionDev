<x-Main-layout>
    @if (session('success'))
        <x-Alert-success>
            {{ session('success') }}
        </x-Alert-success>
    @endif

    <x-Breadcrumbs>
        <a  href="{{route('results.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">RESULTS / Analytics</a>
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

