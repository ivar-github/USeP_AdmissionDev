<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.create')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">REGISTER</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="py-10 px-2">
            <div class="max-w-2xl  dark:bg-gray-800 rounded-xl border-2 border-dashed py-10 dark:border-gray-500">
                <div class="px-6 text-gray-900  dark:text-gray-100 ">
                    <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">
                        User Registration
                    </h2>

                    <p class="mt-1 text-md mb-10 text-gray-600 dark:text-gray-400">
                        Add user account's information and email address
                    </p>
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <x-Validation-Error :messages="$errors->get('name')" class="mt-2" />
                        <x-Validation-Error :messages="$errors->get('email')" class="mt-2" />
                        <x-Validation-Error :messages="$errors->get('password')" class="mt-2" />
                        <x-Validation-Error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        <x-Validation-Error :messages="$errors->get('type')" class="mt-2" />
                        <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                        <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                            <div class=" text-white">
                                <x-Input-Label for="name">Full Name</x-Input-Label>
                                <x-Input-Field id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required   />
                            </div>
                            <div class=" text-white">
                                <x-Input-Label for="email">Email Address</x-Input-Label>
                                <x-Input-Field id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required  />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                            <div class=" text-white">
                                <x-Input-Label for="password">Password</x-Input-Label>
                                <x-Input-Field id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                            </div>
                            <div class=" text-white">
                                <x-Input-Label for="password_confirmation">Confirm Password</x-Input-Label>
                                <x-Input-Field id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                            <div class=" text-white">
                                <x-Input-Label for="type">Account Type</x-Input-Label>
                                <x-Input-Dropdown name="type" id="type">
                                    <option value="" disabled selected>Select</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </x-Input-Dropdown>
                            </div>
                            <div class=" text-white">
                                <x-Input-Label for="status">Status</x-Input-Label>
                                <x-Input-Dropdown name="status" id="status">
                                    <option value="" disabled selected>Select</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </x-Input-Dropdown>
                            </div>
                        </div>
                        <div class="flex items-center  mt-4">
                            <x-Input-Submit class="mt-4">
                                Register
                            </x-Input-Submit>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>
