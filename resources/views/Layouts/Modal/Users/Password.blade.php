<!-- MODAL-->
<div id="editPasswordModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Reset Password</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="editPasswordModal" data-modal-toggle="editPasswordModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editPasswordForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="userIdPw" name="userIdPw">

                <div id="p_errorMessage" class="mt-4 text-red-500">
                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="p_name">Full Name</x-Input-Label>
                        <x-Input-Field id="p_name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" disabled   />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="p_email">Email Address</x-Input-Label>
                        <x-Input-Field id="p_email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" disabled  />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="password">Password</x-Input-Label>
                        <button type="button" id="generateResetPassword" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 w-full">
                            Generate Password
                        </button>
                    </div>
                    <div class=" text-white">
                        <x-Input-Label>&nbsp;</x-Input-Label>
                        <x-Input-Field id="p_password" class="block mt-1 w-full"
                                        type="text"
                                        name="password"
                                        placeholder="Password"
                                        required autocomplete="new-password" />
                    </div>
                </div>
                <div class="flex items-center  mt-4">
                    <x-Input-Submit class="mt-4">
                        Submit
                    </x-Input-Submit>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('generateResetPassword').addEventListener('click', function () {
        const password = Math.random().toString(36).slice(-8);
        document.getElementById('p_password').value = password;
    });
</script>
