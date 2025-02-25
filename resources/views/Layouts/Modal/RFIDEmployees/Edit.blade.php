<!-- MODAL-->
<div id="editEmployeeModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Employee's RFID</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="editEmployeeModal" data-modal-toggle="editEmployeeModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editEmployeeRFIDForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="employeeID" name="employeeID">

                <div class="flex flex-col items-center mt-2 pb-8 px-5 md:px-10">
                    <img id="i_photo" class="w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full shadow-xl ring-1 ring-gray-300 mx-auto" alt="Image">
                    <h6 id="i_employeeid" class="mb-1 text-lg font-medium text-gray-900 dark:text-white">
                    </h6>
                    <h5 id="i_name" class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                    </h5>
                    <span id="i_email" class="text-sm text-gray-500 dark:text-gray-400">
                    </span>

                    <div class="w-full mt-10 mx-2 ">
                        <div id="e_errorMessage" class="mt-2 text-red-500">
                            <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <x-Validation-error :messages="$errors->get('rfid')" class="mt-2" />
                        <div class="relative">
                            <input type="number" name="rfid" id="e_rfid" class="block p-4 w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="RFID Number" required />
                            <label for="smartID" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-red-800 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">SmartCard ID</label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center  mt-4">
                    <x-Input-Submit class="mt-4">
                        Update
                    </x-Input-Submit>
                </div>
            </form>

        </div>
    </div>
</div>
