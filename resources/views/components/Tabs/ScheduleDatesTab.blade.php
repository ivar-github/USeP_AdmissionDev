
<ul class=" text-sm font-medium text-center text-gray-500 rounded-lg shadow  grid  grid-cols-2 md:grid-cols-4 dark:divide-gray-700 dark:text-gray-400"> 
    <li class="w-full focus-within:z-10">
        <a href="{{ route('courseEvalParameters.index') }}" class="inline-block w-full p-4 bg-white border border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page">Parameters</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a href="{{ route('courseEvalStatements.index') }}" class="inline-block w-full p-4 bg-white border border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Statements</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a href="{{ route('courseEvalRemarks.index') }}" class="inline-block w-full p-4 bg-white border border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Remarks</a>
    </li>
    <li class="w-full focus-within:z-10">
        <a href="{{ route('courseEvalRatings.index') }}" class="inline-block w-full p-4 bg-white border  border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Ratings</a>
    </li>
</ul>