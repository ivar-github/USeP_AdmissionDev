<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('scheduleReschedules.index')}}" class="ms-1 text-md font-small md:text-lg md:font-medium  text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">SCHEDULES - Rescheduling</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- CONTENT --}}
                <div class="flex flex-col xl:flex-row boorder gap-4 rounded-lg">
                    {{-- LEFT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-2xl lg:text-3xl font-extrabold tracking-tight">
                                Search Examinee
                            </h1>
                            <hr class="mb-5">
                            <div class="dark:text-gray-200   mb-2">
                                <label for="termID" class="block text-md text-gray-700  dark:text-gray-300">Term </label>
                                <select id="termID" name="termID" onchange="getDataByTerm()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($terms as $term)
                                        <option value="{{ $term->TermID }}">({{ $term->TermID }}) &nbsp; {{ $term->AcademicYear }} &nbsp;&nbsp;{{ $term->SchoolTerm }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="examineeSearch" oninput="handleInputChange(event)"  class="block w-full p-3 ps-10 text-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Applicant's No. or Name" required />
                                <button type="submit" onclick="fetchExaminees()" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-1 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                            </div>
                    
                            <div class="relative overflow-x-auto mt-4">
                                <div class="py-2">
                                    <p id="noResult" class="text-center font-semibold text-gray-700 dark:text-gray-100 hidden">No examinee found!</p>
                                    <div id="examineeList" class="max-h-[420px] min-h-[80px] overflow-y-auto  border border-gray-300 rounded-lg  p-2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    {{-- RIGHT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-xl lg:text-3xl font-extrabold tracking-tight ">Examination Details</h1>
                            <hr class="mb-3">
                            <div class="grid grid-cols-1 gap-3 mt-3">
                                <div class="text-gray-900 space-y-2">
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">App-No. :</p>
                                        <p id="i_appno" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Name :</p>
                                        <p id="i_name" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Date:</p>
                                        <p id="i_date" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Time:</p>
                                        <p id="i_time" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Center:</p>
                                        <p id="i_center" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Room:</p>
                                        <p id="i_room" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                    <div class="flex">
                                        <p class="text-sm font-bold text-gray-600 w-24 dark:text-gray-400">Code:</p>
                                        <p id="i_code" class="text-sm font-bold text-gray-900 dark:text-gray-300 flex-1">
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                            <form method="POST" id="editExamineeSchedForm">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" id="applicantID" name="applicantID">

                                <input type="hidden" id="e_term" name="Term">
                                <input type="hidden" id="e_center" name="Center">
                                <input type="hidden" id="e_date" name="Date">
                                <input type="hidden" id="e_time" name="Time">
                                <input type="hidden" id="e_room" name="Room">
                                <input type="hidden" id="e_session" name="Session">
                
                                <div id="e_errorMessage" class="mt-4 text-red-500">
                                    <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                                <div class="grid grid-cols-1 mt-5 gap-4">
                                    <div class="dark:text-gray-200   mb-2">
                                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Select Test Center:</p>
                                        <select  id="centerID" onchange="getAvailableScheds()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            @foreach ($testCenters as $testCenter)
                                                <option value="{{ $testCenter->id }}">{{ $testCenter->testCenterName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-gray-800 dark:text-white dark:text-gray-200 ">
                                        <div id="e_errorMessage" class="mt-2 text-red-500">
                                            <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                                        </div>
                                        <x-Validation-error :messages="$errors->get('Slots')" class="mt-2" />
                                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Select Available Schedules:</p>
                                        <div class="flex items-center gap-2">
                                            <x-Input-Dropdown name="Slots" id="e_slots" onchange="selectSchedDetails()"></x-Input-Dropdown>
                                            <button type="button" onclick="getAvailableScheds()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="flex items-center">
                                    <x-Input-Submit class="mt-4">Update</x-Input-Submit>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
    </div>

    @push('scripts')

        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalUnique.js') }}"></script>
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                 // FUNCTION UPDATE SCHEDULE
                 document.getElementById('editExamineeSchedForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const applicantID = document.getElementById('applicantID').value;

                    axios.post(`/admission/schedule/scheduleReschedules/${applicantID}`, formData)
                    .then(response => {
                            this.reset();
                            document.getElementById('e_errorMessage').innerHTML = '';
                            swalGenericSinglePageUpdate(response.data.message);
                            fetchExaminees();
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('e_errorMessage');
                                errorList.innerHTML = '';

                                for (const key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        const errorMessage = document.createElement('li');
                                        errorMessage.innerText = errors[key][0];
                                        errorList.appendChild(errorMessage);
                                    }
                                }
                            } else {
                                const errorMsg = error.response.data.message;
                                console.log('ErrorMsg',errorMsg);
                                console.log('Error',error);
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

            });


            //DAFAULT VALUE
            defaultIDValue();

            function handleInputChange(event) {
                // const searchValue = event.target.value;
                // fetchStudents(); 

            }

            // FUNCTION TO GET SET DAFAULT VALUE
            function defaultIDValue() {
                document.getElementById('applicantID').value = 0;
                document.getElementById('i_center').textContent = '';
                document.getElementById('i_date').textContent =  '';
                document.getElementById('i_time').textContent =  '';
                document.getElementById('i_room').textContent =  '';
                document.getElementById('i_appno').textContent =  '';
                document.getElementById('i_name').textContent =  '';
                document.getElementById('i_code').textContent =  '';
            }


            // FUNCTION TO GET AVAILABLE SCHEDULES
            function getAvailableScheds() {
                axios.get('/api/admission/schedule/reschedule/getAvailableScheds', {
                        params: {
                            centerID: document.getElementById('centerID').value,
                        },
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(response => {
                        const availableSlotSelect = document.getElementById('e_slots');
                        availableSlotSelect.innerHTML = '<option value="0" disabled selected>Select</option>';
                        response.data.forEach(applicants => {
                            const option = document.createElement('option');
                            option.value = applicants.id;
                            option.text = `${applicants.testCenterName}  ${applicants.testDate}  ${applicants.testTimeStartString} - ${applicants.testTimeEndString}   ${applicants.testRoomName}  [${applicants.totalRegistered} / ${applicants.availableSlots} ]`
                            availableSlotSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching Available Scheds:', error));
            }


            // FUNCTION TO SELECT SCHED DETAILS
            function selectSchedDetails() {
                axios.get('/api/admission/schedule/reschedule/selectSchedDetails', {
                        params: {
                            e_slotID: document.getElementById('e_slots').value,
                        },
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    })
                    .then(response => {
                        const details = response.data;
                        document.getElementById('e_term').value = details.termID;
                        document.getElementById('e_center').value = details.testCenterID;
                        document.getElementById('e_date').value = details.testDateID;
                        document.getElementById('e_time').value = details.testTimeID;
                        document.getElementById('e_session').value = details.testSessionID;
                        document.getElementById('e_room').value = details.testRoomID;
                        document.getElementById('i_center').textContent = details.testCenterName;
                        document.getElementById('i_date').textContent = details.testDate;
                        document.getElementById('i_time').textContent = `${details.testTimeStartString} -${details.testTimeEndString}`;
                        document.getElementById('i_room').textContent = details.testRoomName;
                    })
                    .catch(error => console.error('Error fetching Sched Details:', error));
            }


            // FUNCTION TO SHOW SCHEDULE TO EDIT
            function openEditModal(id) {
                console.log("Student ID Sent to Axios:", id, typeof id);
                axios.get(`/admission/schedule/scheduleReschedules/${id}/edit`)
                    .then(response => {
                        const applicant = response.data;
                        document.getElementById('applicantID').value = applicant.id;
                        document.getElementById('centerID').value = applicant.testCenterID;
                        document.getElementById('e_term').value = applicant.termID;
                        document.getElementById('e_center').value = applicant.testCenterID;
                        document.getElementById('e_date').value = applicant.testDateID;
                        document.getElementById('e_time').value = applicant.testTimeID;
                        document.getElementById('e_session').value = applicant.testSessionID;
                        document.getElementById('e_room').value = applicant.testRoomID;
                        document.getElementById('i_center').textContent = applicant.testCenterName;
                        document.getElementById('i_date').textContent = applicant.testDate;
                        document.getElementById('i_time').textContent = `${applicant.testTimeStartString}-${applicant.testTimeEndString}`;
                        document.getElementById('i_room').textContent = applicant.testRoomName;
                        document.getElementById('i_appno').textContent = applicant.appNo;
                        document.getElementById('i_name').textContent = applicant.Name;
                        document.getElementById('i_code').textContent = applicant.testScheduleCode; 

                        getAvailableScheds();
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        swalGenericError('An unexpected error occurred!', error);
                    });
            }


            // FUNCTION TO SHOW EXAMINEES
            function fetchExaminees() {
                axios.get('/api/rfid/applicantSchedules', {
                    params: { 
                            examinee: document.getElementById('examineeSearch').value,
                            termID: document.getElementById('termID').value,
                        },
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(response => {
                    defaultIDValue();
                    document.getElementById('e_errorMessage').innerHTML = '';
                    const examineeList = document.getElementById('examineeList');
                    const noResult = document.getElementById('noResult');
                    examineeList.innerHTML = '';

                    if (response.data.examinees.length === 0) {
                        noResult.classList.remove("hidden");
                    } else {
                        noResult.classList.add("hidden");
                    }

                    const ul = document.createElement('ul');
                    ul.classList.add("max-w-md", "divide-y", "divide-gray-200", "dark:divide-gray-700", "mx-auto");

                    response.data.examinees.forEach(examinee => {
                        const li = document.createElement('li');
                        li.classList.add("justify-content", "mx-auto", "border-b", "border-gray-200", "dark:border-gray-700", "py-2");

                        li.innerHTML = `
                            <div class="flex items-center  px-1 lg:px-4 space-x-4 rtl:space-x-reverse">
                                <div class="flex-1 min-w-0">
                                    <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">${examinee.appNo}</p>
                                    <p class="text-sm font-sm text-gray-900 truncate dark:text-gray-300">${examinee.Name}</p>
                                    <p class="text-sm font-sm text-gray-900 truncate dark:text-gray-300">${examinee.testDate} ${examinee.testTimeStartString}-${examinee.testTimeEndString}</p>
                                    <p class="text-sm font-sm text-gray-900 truncate dark:text-gray-300">${examinee.testCenterName}-${examinee.testRoomName}</p>
                                </div>
                                <div class="md:inline-flex gap-5 items-center text-base font-semibold text-gray-900 dark:text-white">
                                    <a href="javascript:void(0)" onclick="openEditModal('${examinee.id}')" data-modal-target="editExamineeSchedModal" data-modal-toggle="editExamineeSchedModal" class="hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                        </svg>
                                    </a>
                                    <button onclick="swalDelete('${examinee.id}', '${examinee.appNo}')" class="hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;

                        ul.appendChild(li);
                    });

                    examineeList.appendChild(ul);
                })
                .catch(error => console.error("Error fetching examinees:", error));
            }
            
            // FUNCTION TO DELETE ITEM
            function swalDelete(id, appNo) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('scheduleReschedules.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            data: {
                                appNo: appNo   
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                fetchExaminees();
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                            }
                        })
                        .catch(error => {
                            const errorMsg = error.response.data.message;
                            console.log('ErrorMsg',errorMsg);
                            console.log('Error',error);
                            swalGenericError('An unexpected error occurred!',errorMsg);
                        });
                    }
                });
            }

        </script>
    @endpush

</x-Main-layout>
