<!-- MODAL-->
<div id="editParameterModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Parameter</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="editParameterModal" data-modal-toggle="editParameterModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editParameterForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="parameterId" name="parameterId">

                <div id="e_errorMessage" class="mt-4 text-red-500">
                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="grid grid-cols mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_name">Name</x-Input-Label>
                        <x-Input-TextArea id="e_name" class="block mt-1 w-full"
                            name="Name"
                            :value="old('Name')"
                            required />
                    </div>
                </div>
                <div class="grid grid-cols mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_desc">Description</x-Input-Label>
                        <x-Input-TextArea id="e_desc" class="block mt-1 w-full"
                            name="Description"
                            :value="old('Description')"
                            required />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_sortorderN">SortOrder No.</x-Input-Label>
                        <x-Input-Field id="e_sortorderN" class="block mt-1 w-full"
                            type="number"
                            name="SortOrder_Num"
                            required />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_sortorderA">SortOrder Alph.</x-Input-Label>
                        <x-Input-Field id="e_sortorderA" class="block mt-1 w-full"
                            type="text"
                            name="SortOrder_Alpha"
                            required />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_status">Status</x-Input-Label>
                        <x-Input-Dropdown name="Status" id="e_status">
                            <option value="" disabled selected>Select</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </x-Input-Dropdown>
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_evaltypeID">EvalType ID</x-Input-Label>
                        <x-Input-Dropdown name="EvalType_ID" id="e_evaltypeID">
                            <option value="" disabled selected>Select</option>
                            <option value="21">Course Evaluation</option>
                        </x-Input-Dropdown>
                    </div>
                </div>
                <div class="flex items-center  mt-4">
                    <x-Input-Submit class="mt-4">
                        Update
                    </x-Input-Submit>
                </div>
            </form>

        </div>
    </div>
</div>
