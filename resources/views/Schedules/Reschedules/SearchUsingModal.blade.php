<x-Main-layout>
    @if ($errors->any())
        <x-Alert-error>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-Alert-error>
    @endif
    <div class="py-5 ">
        <x-Breadcrumbs>
            <a  href="{{route('scheduleApplicants.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">EMPLOYEES</a>
        </x-Breadcrumbs>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg  py-10 px-2">
                <div class="px-2 md-px-10 mx-auto max-w-lg py-10 rounded-xl shadow-1xl">
                    <h1 class="text-2xl text-center bg-red-800 mb-10 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Search Applicant
                    </h1>
                    <x-Validation-error :messages="session('notfound')" class="mt-2" />
                    <form method="POST" action="{{ route('scheduleApplicants.search')}}">
                        @csrf
                        <div class="dark:text-gray-200 mx-2 mb-2">
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
                            <input type="text" value="{{old('applicant', $search )}}" name="applicant" id="applicant" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Applicant's No. or Name" required />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                    <div class="relative overflow-x-auto mt-5">
                        <div class="p-5 ">
                            @if ($applicants->isEmpty())
                                <p class="text-center font-semibold text-gray-700 dark:text-gray-100">No Applicant Found!!</p>
                            @else
                                <ul class="max-w-md divide-y py-2  divide-gray-200 dark:divide-gray-700 mx-auto justify-center justify-items-center justify-self-center">
                                    @foreach ($applicants as $applicant)
                                        <li class=" justify-content mx-auto  ">
                                            <div class="flex items-center py-2 space-x-4 rtl:space-x-reverse ">

                                                <div class="flex-shrink-0">
                                                    <img class="w-10 h-10 rounded-full" src="{{ $applicant->Photo_base64 ? $applicant->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-lg font-bold text-gray-1000 truncate dark:text-gray-400">
                                                        {{ $applicant->appNo }}
                                                    </p>
                                                    <p class="text-md font-semibold text-gray-1000 truncate dark:text-gray-400">
                                                       {{ $applicant->testScheduleCode }}
                                                    </p>
                                                    <p class="text-md font-medium text-gray-900 truncate dark:text-gray-300">
                                                       {{ $applicant->Name }}
                                                    </p>
                                                    {{-- <hr class='me-5 my-1'> --}}
                                                    <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">
                                                       {{ $applicant->testDate }}  ({{ $applicant->testTimeStartString }}-{{ $applicant->testTimeEndString }})
                                                    </p>
                                                    <p class="text-md font-medium text-gray-900 truncate dark:text-gray-300">
                                                       {{ $applicant->testCenterName }} - {{ $applicant->testRoomName }} 
                                                    </p>
                                                </div>
                                                <div class="inline-flex gap-5 items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <a href="javascript:void(0)" onclick="openEditModal({{ $applicant->id }})" data-modal-target="editExamineeSchedModal" data-modal-toggle="editExamineeSchedModal" class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                    <button onclick="swalDelete({{  $applicant->id }})" class="hover:text-red-700 "  >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <hr>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- @include('Layouts.Modal.ScheduleReschedules.Create') --}}
            @include('Layouts.Modal.ScheduleReschedules.Edit')
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

                    axios.post(`/scheduleApplicants/${applicantID}`, formData)
                    .then(response => {
                            closeEditModal();
                            this.reset();
                            document.getElementById('e_errorMessage').innerHTML = '';
                            swalGenericUpdate(response.data.message);
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
                                swalGenericError('An unexpected error occurred!',error);
                            }
                        });
                });

            });


            //GET AVAILABL SCHEDS
            getAvailableScheds();


            // FUNCTION TO GET AVAILABLE SCHEDULES
            function getAvailableScheds() {
                axios.get('/api/scheduleApplicant/getAvailableScheds', {
                        params: {
                            campusID: document.getElementById('campusID').value,
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
            
            // FUNCTION TO REFRESH AVALIABLE SCHEDS
            function refreshAvailableScheds() {
                getAvailableScheds();
            }


            // FUNCTION TO SELECT SCHED DETAILS
            function selectSchedDetails() {
                axios.get('/api/scheduleApplicant/selectSchedDetails', {
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
                        document.getElementById('e_schedule').value = `${details.testDate}  ${details.testTimeStartString} - ${details.testTimeEndString} \n${details.testCenterName} - ${details.testRoomName}`;

                    })
                    .catch(error => console.error('Error fetching Sched Details:', error));
            }


            // FUNCTION TO SHOW SCHEDULE TO EDIT
            function openEditModal(appID) {
                axios.get(`/scheduleApplicants/${appID}/edit`)
                    .then(response => {
                        const applicant = response.data;
                        document.getElementById('applicantID').value = applicant.id;
                        document.getElementById('campusID').value = applicant.campusID;
                        document.getElementById('e_term').value = applicant.termID;
                        document.getElementById('e_center').value = applicant.testCenterID;
                        document.getElementById('e_date').value = applicant.testDateID;
                        document.getElementById('e_time').value = applicant.testTimeID;
                        document.getElementById('e_session').value = applicant.testSessionID;
                        document.getElementById('e_room').value = applicant.testRoomID;
                        document.getElementById('e_schedule').value = `${applicant.testDate}  ${applicant.testTimeStartString} - ${applicant.testTimeEndString} \n${applicant.testCenterName} - ${applicant.testRoomName}`;
                    
                        getAvailableScheds();
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        swalGenericError('An unexpected error occurred!', error);
                    });
            }

            
            // FUNCTION TO DELETE ITEM
            function swalDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "Yes, Delete It",
                    cancelButtonText: 'No, Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.action = `{{ route('scheduleApplicants.destroy', '') }}/${id}`;
                        form.method = 'POST';
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                        swalGenericDelete();
                    }
                });
            }


            function closeEditModal() {
                document.getElementById('editExamineeSchedModal').classList.add('hidden');
                document.getElementById('e_errorMessage').innerHTML = '';
            }

        </script>
    @endpush

</x-Main-layout>

