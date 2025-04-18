<!-- MODAL -->
<div id="editManualEnlistModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 left-0 right-0 z-50 flex justify-center items-center  w-full h-full bg-gray-900 bg-opacity-70">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- MODAL Content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- MODAL Header-->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">MANUAL ENLIST</h3>
                <button type="button" onclick="closeEditModal()"  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- MODAL Body-->
            <form method="POST" id="editManualEnlistForm">
                @csrf
                @method('POST')
                <input type="hidden" id="appID" name="appID">
                <input type="hidden" id="current_term" name="current_term">
                <input type="hidden" id="current_status" name="current_status">

                <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-lg lg:text-xl font-extrabold tracking-tight ">Applicant's Current Details</h1>
                <div class="grid grid-cols-1 gap-3 mt-3 mx-2">
                    <div class="text-gray-900 space-y-1 ">
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Applicant No.:</p>
                            <p id="i_appNo" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Application Status :</p>
                            <p id="i_status" class="text-md font-semibold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Applicant Name:</p>
                            <p id="i_name" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Track:</p>
                            <p id="i_track" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Strand:</p>
                            <p id="i_strand" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Stanine</p>
                            <p id="i_stanine" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <p class="text-md font-bold text-gray-500 w-full sm:w-40 dark:text-gray-400">Ranking Average:</p>
                            <p id="i_ranking" class="text-md font-bold text-gray-700 dark:text-gray-200 flex-1">
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="my-3">
                <h1 class="text-slate-700 dark:text-white mx-auto mt-5 lg:my-5 text-lg lg:text-xl font-extrabold tracking-tight ">Enlist To Other Course:</h1>
                <div id="e_errorMessageManualEnlist" class="my-5 text-red-500">
                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2">
                    <div class="dark:text-gray-200 mx-2 mb-2">
                        <div class="rounded-lg">
                            <label for="campus" class="block text-md text-gray-700  dark:text-gray-300">Campus</label>
                            <select id="e_campus" name="campus" required onchange="getCollegeByCampus_Edit()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                                <option value="">All </option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="dark:text-gray-200 mx-2 mb-2">
                        <div class="rounded-lg">
                            <label for="college" class="block text-md text-gray-700  dark:text-gray-300">College</label>
                            <select id="e_college" name="college" required onchange="getProgramByCollege_Edit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                                <option value="">All </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 mt=5">
                    <div class="dark:text-gray-200 mx-2 mb-2">
                        <div class="rounded-lg">
                            <label for="program" class="block text-md text-gray-700  dark:text-gray-300">Program</label>
                            <select id="e_program" name="program" required onchange="getMajorByProgram_Edit()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                                <option value="">All </option>
                            </select>
                        </div>
                    </div>
                    <div class="dark:text-gray-200 mx-2 mb-2">
                        <div class="rounded-lg">
                            <label for="major" class="block text-md text-gray-700  dark:text-gray-300">Major</label>
                            <select id="e_major" name="major" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">>
                                <option value="">All </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <x-Input-Submit class="mt-4">Manual Enlist</x-Input-Submit>
                </div>
            </form>

        </div>
    </div>
</div>
