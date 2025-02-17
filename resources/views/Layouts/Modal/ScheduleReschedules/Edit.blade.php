<!-- MODAL-->
<div id="editExamineeSchedModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Schedule</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="editExamineeSchedModal" data-modal-toggle="editExamineeSchedModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editExamineeSchedForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="applicantID" name="applicantID">
                <input type="hidden" id="campusID" name="campusID">

                <div id="e_errorMessage" class="mt-4 text-red-500">
                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_term">Term ID</x-Input-Label>
                        <x-Input-Field id="e_term" class="block mt-1 w-full"
                            type="number"
                            name="Term"
                            required />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_center">Center ID</x-Input-Label>
                        <x-Input-Field id="e_center" class="block mt-1 w-full"
                            type="number"
                            name="Center"
                            required />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_date">Date ID</x-Input-Label>
                        <x-Input-Field id="e_date" class="block mt-1 w-full"
                            type="number"
                            name="Date"
                            required />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_time">Time ID</x-Input-Label>
                        <x-Input-Field id="e_time" class="block mt-1 w-full"
                            type="number"
                            name="Time"
                            required />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_room">Room ID</x-Input-Label>
                        <x-Input-Field id="e_room" class="block mt-1 w-full"
                            type="number"
                            name="Room"
                            required />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="e_session">Session ID</x-Input-Label>
                        <x-Input-Field id="e_session" class="block mt-1 w-full"
                            type="number"
                            name="Session"
                            required />
                    </div>
                </div>

                <div class="grid grid-cols mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_schedule">Test Schedule</x-Input-Label>
                        <x-Input-TextArea id="e_schedule" class="block mt-1 w-full"
                            name="Schedule"
                            required />
                    </div>
                </div>
                <div class="grid grid-cols-1 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="e_slots">
                            Select Available Schedules
                        </x-Input-Label>

                        <div class="flex items-center gap-2 text-gray-800 dark:text-gray-200"> 
                            <x-Input-Dropdown name="Slots" id="e_slots" onchange="selectSchedDetails()">
                            </x-Input-Dropdown>
                            <button type="button" onclick="refreshAvailableScheds()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"  class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </button>
                        </div>
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
