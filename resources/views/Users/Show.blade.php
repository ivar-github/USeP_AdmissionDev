<x-Main-layout>
    <div class="py-5 ">
        <x-breadcrumbs>
            <a  href="{{route('users.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">USER</a>
        </x-breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-2">
                <div class=" max-w-md mx-auto m-5  bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex flex-col items-center py-10 px-5 md:px-10">
                        <img src="{{asset('img_assets/avatar.png') }}" class=" w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full  shadow-xl ring-1 ring-gray-300 mx-auto" alt="Student Photo">
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->email }}
                        </span>
                        <input value="" type="number" name="smartID" id="email" class="bg-gray-50 border w-full mx-2 mt-10 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="SmartCard ID" required />
                        <div class="flex mt-4 md:mt-6">
                            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white  bg-red-900 hover:bg-red-800 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">UPDATE</a>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>
