

<x-Main-layout>
    <div class="py-5 ">
        <x-breadcrumbs>
            <a  href="{{route('users.create')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">REGISTER</a>
        </x-breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg py-10 px-2 ">
                <div class="max-w-xl  mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-xl border-2 py-10 ">
                    <div class="bg-white dark:bg-gray-800 ">
                        <div class="px-6 text-gray-900  dark:text-gray-100 ">
                            <h2 class="text-xl  font-medium text-gray-900 dark:text-gray-100">
                                Update User
                            </h2>
                            <p class="mt-1 text-md mb-10 text-gray-600 dark:text-gray-400">
                                Update user account's information
                            </p>
                            <form method="POST" action="{{ route('users.update', $user->id)}}">
                                @csrf
                                @method('PUT')
                                {{-- <img src="{{asset('img_assets/avatar.png') }}" class=" w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full  shadow-xl ring-1 ring-gray-300 mx-auto" alt="Student Photo"> --}}
                                <x-Validation-Error :messages="$errors->get('name')" class="mt-2" />
                                <x-Validation-Error :messages="$errors->get('email')" class="mt-2" />
                                <x-Validation-Error :messages="$errors->get('type')" class="mt-2" />
                                <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                                    <div class=" text-white">
                                        <x-Input-Label for="name">Full Name</x-Input-Label>
                                        <x-Input-Field id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required value="{{old('name', $user->name )}}"  />
                                    </div>
                                    <div class=" text-white">
                                        <x-Input-Label for="email">Email Address</x-Input-Label>
                                        <x-Input-Field id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" value="{{old('email', $user->email )}}" required  />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                                    <div class=" text-white">
                                        <x-Input-Label for="type">Account Type</x-Input-Label>
                                        <x-Input-Dropdown name="type" id="type">
                                            <option value="0" {{$user->type ? '' : 'selected'}}>User</option>
                                            <option value="1" {{$user->type ? 'selected' : ''}}>Admin</option>
                                        </x-Input-Dropdown>
                                    </div>
                                    <div class=" text-white">
                                        <x-Input-Label for="status">Status</x-Input-Label>
                                        <x-Input-Dropdown name="status" id="status">
                                            <option value="0" {{$user->status ? '' : 'selected'}}>Inactive</option>
                                            <option value="1" {{$user->status ? 'selected' : ''}}>Active</option>
                                        </x-Input-Dropdown>
                                    </div>
                                </div>
                                <div class="flex items-center  *: mt-4">
                                    <x-Input-Submit class="mt-4 mx-auto">
                                       Update User
                                    </x-Input-Submit>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Main-layout>
