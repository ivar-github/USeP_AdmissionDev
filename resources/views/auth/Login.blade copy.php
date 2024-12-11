<x-guest-layout>
    <x-auth-session-status class="mb-2" :status="session('status')" />

    <div class="w-full lg:p-6 md:p-6 p-3 py-5 px-5 bg-white border border-gray-200 rounded-3xl shadow   dark:bg-gray-800 dark:border-gray-700">
        <div class="flex justify-end">
            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <form class="" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mx-auto my-3">
                <img src="img_assets/usep.png" class="h-32 block mx-auto" alt="Image with fixed height">
            </div>
            <h5 class="text-2xl md:text-3xl font-medium text-gray-900 my-5 dark:text-white text-center">USeP Admission System</h5>

            <div class="my-3">
                <x-Validation-Error :messages="$errors->get('inactive')" class="mt-2 md:text-sm text-xs " />
                <x-Validation-Error :messages="$errors->get('email')" class="mt-2 md:text-sm text-xs " />
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="email" id="email" :value="old('email')" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="johndoe@usep.edu.ph" required />
            </div>
            <div class="my-3">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" name="password" id="password"   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                <x-Validation-Error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="flex items-start ">
                <div class="flex items-start">
                    <!-- <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"  />
                    </div> -->
                    <!-- <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label> -->
                </div>
                {{-- <a href="#" class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a> --}}
            </div>
            <button type="submit" class="w-full mt-7 text-white bg-red-900 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">LOGIN</button>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                {{-- Not registered? <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a> --}}
            </div>
        </form>
    </div>

    
</x-guest-layout>

