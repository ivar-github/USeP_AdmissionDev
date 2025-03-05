<!-- MODAL -->
<div id="editScheduleSlotModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 left-0 right-0 z-50 flex justify-center items-center  w-full h-full bg-gray-900 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Schedule</h3>
                <button type="button" onclick="closeEditModal('${rowID}')"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editScheduleSlotForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="slotID" name="slotID">
                <input type="hidden" id="campusID" name="campusID">

                <div id="e_errorMessageSlot" class="mt-4 text-red-500">
                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 mt-4 gap-4">
                    <div class="text-white">
                        <x-Input-Label for="Term">Term</x-Input-Label>
                        <select id="e_slotTerm" name="Term"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="" disabled selected>Select Term </option>
                            @foreach ($terms as $term)
                            <option value="{{ $term->TermID }}">({{ $term->TermID }}) &nbsp; {{ $term->AcademicYear }} &nbsp;&nbsp;{{ $term->SchoolTerm }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="text-white">
                        <x-Input-Label for="Center">Test Center</x-Input-Label>
                        <select id="e_slotCenter" name="Center"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="0" disabled selected>Select Center </option>
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->testCenterName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-4 gap-4">
                    <div class="text-white">
                        <x-Input-Label for="Date">Date</x-Input-Label>
                        <select id="e_slotDate" name="Date"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="" disabled selected>Select Date </option>
                            @foreach ($dates as $date)
                                <option value="{{ $date->id }}">{{ $date->testDate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-white">
                        <x-Input-Label for="Time">Time</x-Input-Label>
                        <select id="e_slotTime" name="Time"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="" disabled selected>Select Time </option>
                            @foreach ($times as $time)
                                <option value="{{ $time->id }}">{{ $time->testTimeStartString }} - {{ $time->testTimeEndString }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 mt-4 gap-4">
                    <div class="text-white">
                        <x-Input-Label for="Session">Session</x-Input-Label>
                        <select id="e_slotSession" name="Session"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="" disabled selected>Select Session </option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->testSessionName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-white">
                        <x-Input-Label for="Room">Room</x-Input-Label>
                        <select id="e_slotRoom" name="Room"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="" disabled selected>Select Room </option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->testRoomName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 mt-4 gap-4">
                    <div class=" text-white">
                        <x-Input-Label for="Slot">Slot Limit</x-Input-Label>
                        <x-Input-Field id="e_slotLimit" class="block mt-1 w-full" type="number" name="Slot" :value="old('Slot')" required   />
                    </div>
                    <div class=" text-white">
                        <x-Input-Label for="Status">Status</x-Input-Label>
                        <x-Input-Dropdown name="Status" id="e_slotStatus">
                            <option value="" disabled selected>Select</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </x-Input-Dropdown>
                    </div>
                </div>
                <div class="flex items-center mt-4">
                    <x-Input-Submit class="mt-4">Update</x-Input-Submit>
                </div>
            </form>

        </div>
    </div>
</div>
