<x-Main-layout>
        <x-Breadcrumbs>
            <a  href="{{route('employeesRFIDs.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">RFID - Employees</a>
        </x-Breadcrumbs>
        <div class="mx-auto h-full">
            <div class="overflow-hidden py-5 lg:py-10">
                <div class="px-2 md-px-10 mx-auto max-w-lg py-10 rounded-xl shadow-1xl">
                    <h1 class="text-2xl text-center bg-red-800 mb-10 font-semibold text-gray-100 p-3 rounded-xl dark:text-gray-100">
                        Search Employee
                    </h1>
                    <x-Validation-error :messages="session('notfound')" class="mt-2" />
                    <form method="POST" action="{{ route('employeesRFIDs.search')}}">
                        @csrf
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" value="{{old('rfid', $search )}}" name="rfid" id="rfid" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Employee's ID or Name" required />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                        </div>
                    </form>
                    <div class="relative overflow-x-auto mt-5">
                        <div class="p-5 ">
                            @if ($employees->isEmpty())
                                <p class="text-center font-semibold text-gray-700 dark:text-gray-100">No Employee Found!!</p>
                            @else
                                <ul class="max-w-md divide-y py-2  divide-gray-200 dark:divide-gray-700 mx-auto justify-center justify-items-center justify-self-center">
                                    @foreach ($employees as $employee)
                                        <li class=" justify-content mx-auto  ">
                                            <div class="flex items-center py-2 space-x-4 rtl:space-x-reverse ">

                                                <div class="flex-shrink-0">
                                                    <img class="w-10 h-10 rounded-full" src="{{ $employee->Photo_base64 ? $employee->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">
                                                        {{ $employee->EmployeeID }}
                                                    </p>
                                                    <p class="text-md font-medium text-gray-900 truncate dark:text-gray-300">
                                                        {{ $employee->Prefix }} {{ $employee->LastName }}, {{ $employee->FirstName }} {{ $employee->MiddleName }}
                                                    </p>
                                                    <p class="text-sm font-italic text-gray-500 truncate dark:text-gray-400">
                                                       RFID # : {{ $employee->SmartCardID }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <a href="javascript:void(0)" onclick="openEditModal('{{ $employee->EmployeeID }}')" data-modal-target="editEmployeeModal" data-modal-toggle="editEmployeeModal"  class="hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor"  
                                                            viewBox="0 -960 960 960" class="w-5 h-5">
                                                            <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                @include('Layouts.Modal.RFIDEmployees.Edit')

            </div>
        </div>

    @push('scripts')

        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalUnique.js') }}"></script>
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function() {

                 // FUNCTION TO UPDATE SCHEDULE
                 document.getElementById('editEmployeeRFIDForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const employeeID = document.getElementById('employeeID').value;

                    axios.post(`/rfid/employeesRFIDs/${employeeID}`, formData)
                    .then(response => {
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
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });

            });
            // FUNCTION TO SHOW EMPLOYEE TO EDIT
            function openEditModal(id) {
                console.log("Employee ID Sent to Axios:", id, typeof id);

                axios.get(`/rfid/employeesRFIDs/${id}/edit`)
                // axios.get(`/rfid/employeesRFIDs/${String(id)}/edit`)

                    .then(response => {
                        const employee = response.data;
                        document.getElementById('employeeID').value = employee.EmployeeID;
                        document.getElementById('i_employeeid').textContent = employee.EmployeeID;
                        document.getElementById('e_rfid').value = employee.SmartCardID;
                        document.getElementById('i_email').textContent = employee.Email;
                        document.getElementById('i_name').textContent = `${employee.Prefix} ${employee.LastName} ${employee.FirstName} ${employee.MiddleName}`;
                        if (employee.Photo) {
                            document.getElementById('i_photo').src = `data:image/png;base64,${employee.Photo}`;
                        } else {
                            document.getElementById('i_photo').src = "/img_assets/avatar.png";   
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        swalGenericError('An unexpected error occurred!', error);
                    });
            }

        </script>

    @endpush

</x-Main-layout>

