<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('employeesRFIDs.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">RFID - Employees</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden  sm:rounded-lg">
                {{-- CONTENT --}}
                <div class="flex flex-col xl:flex-row boorder  gap-4 rounded-lg">
                    {{-- LEFT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-2xl lg:text-3xl font-extrabold tracking-tight">
                                Search Employee
                            </h1>
                            <hr class="mb-5">

                            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="employeeSearch" oninput="handleInputChanged(event)"  class="block w-full p-3 ps-10 text-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Employee's No. or Name" required />
                                <button type="submit" onclick="fetchEmployees()" class="text-white absolute end-2.5 bottom-2.5  bg-red-900 hover:bg-red-800 focus:ring-1 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 dark:bg-red-900 dark:hover:bg-red-800 dark:focus:ring-blue-800">Search</button>
                            </div>
                    
                            <div class="relative overflow-x-auto mt-4">
                                <div class="py-2">
                                    <p id="noResult" class="text-center font-semibold text-gray-700 dark:text-gray-100 hidden">No employee found!</p>
                                    <div id="employeeList" class="max-h-[420px] min-h-[80px] overflow-y-auto  border border-gray-300 rounded-lg  p-2">

                                    </div>
                                </div>
                            </div>

                            {{-- <a href="javascript:void(0)" onclick="openEditModal('{{ 202436}}')" data-modal-target="editEmployeeModal" data-modal-toggle="editEmployeeModal"  class="hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor"  
                                    viewBox="0 -960 960 960" class="w-5 h-5">
                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                </svg>
                            </a> --}}
                        </div>
                    </div>
                
                    {{-- RIGHT --}}
                    <div class="w-full xl:w-1/2 bg-white dark:bg-gray-800 p-1 xl:p-4 shadow rounded-lg">
                        <div class="px-2 md-px-2 mx-auto max-w-xl py-3 rounded-xl shadow-1xl">
                            <h1 class="text-slate-700 dark:text-white mx-auto my-2 lg:my-5 text-xl lg:text-3xl font-extrabold tracking-tight ">Employee Details</h1>
                            <hr class="mb-3">
                            <form method="POST" id="editEmployeeRFIDForm">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" id="employeeID" name="employeeID">

                                <div class="flex flex-col items-center mt-5 pt-5 pb-8 px-5 md:px-10">
                                    <img id="i_photo" class="w-24 h-24 md:w-32 md:h-32 mb-3 rounded-full shadow-xl ring-1 ring-gray-300 mx-auto" alt="Image">
                                    <h6 id="i_employeeid" class="mb-1 text-lg font-medium text-gray-900 dark:text-white">
                                        Employee ID
                                    </h6>
                                    <h5 id="i_name" class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                        Employee Name
                                    </h5>
                                    <span id="i_email" class="text-sm text-gray-500 dark:text-gray-400">
                                        Email Address
                                    </span>

                                    <div class="w-full mt-10 mx-2 ">
                                        <div id="e_errorMessage" class="mt-2 text-red-500">
                                            <x-Validation-Error :messages="$errors->get('status')" class="mt-2" />
                                        </div>
                                        <x-Validation-error :messages="$errors->get('rfid')" class="mt-2" />
                                        <div class="relative">
                                            <input type="number" name="rfid" id="e_rfid" class="block p-4 w-full text-md text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  required />
                                            <label for="smartID" class="absolute text-md text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 peer-focus:text-red-800 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">SmartCard ID</label>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="flex items-center justify-center">
                                    <x-Input-Submit class="mt-4">Update</x-Input-Submit>
                                </div>
                            </form>
                        </div>
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
                        // this.reset();
                        document.getElementById('e_errorMessage').innerHTML = '';
                        swalGenericSinglePageUpdate(response.data.message);
                        fetchEmployees(); 
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


        //DAFAULT IMAGE SRC
        defaultIDValue();


        function handleInputChange(event) {
            const searchValue = event.target.value;
            fetchEmployees(); 

        }

        // FUNCTION TO GET AVALIABLE SCHEDS BY CENTER
        function defaultIDValue() {
            document.getElementById('i_photo').src = "/img_assets/avatar.png";   
        }


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
                    document.getElementById('i_photo').src = employee.Photo 
                        ? `data:image/png;base64,${employee.Photo}`
                        : "/img_assets/avatar.png";

                        
                    const modal = document.getElementById('editEmployeeModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    swalGenericError('An unexpected error occurred!', error);
                });
        }


        function fetchEmployees() {
            axios.get('/api/rfid/employees', {
                params: { employee: document.getElementById('employeeSearch').value,
                    },
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(response => {
                const employeeList = document.getElementById('employeeList');
                const noResult = document.getElementById('noResult');
                employeeList.innerHTML = '';

                if (response.data.employees.length === 0) {
                    noResult.classList.remove("hidden");
                } else {
                    noResult.classList.add("hidden");
                }

                const ul = document.createElement('ul');
                ul.classList.add("max-w-md", "divide-y", "divide-gray-200", "dark:divide-gray-700", "mx-auto");

                response.data.employees.forEach(employee => {
                    const li = document.createElement('li');
                    li.classList.add("justify-content", "mx-auto", "border-b", "border-gray-200", "dark:border-gray-700", "py-2");

                    li.innerHTML = `
                        <div class="flex items-center  px-1 lg:px-4 space-x-4 rtl:space-x-reverse">
                            <div class="flex-1 min-w-0">
                                <p class="text-md font-bold text-gray-1000 truncate dark:text-gray-400">${employee.EmployeeID}</p>
                                <p class="text-sm font-sm text-gray-900 truncate dark:text-gray-300">${employee.Prefix} ${employee.LastName}, ${employee.FirstName} ${employee.MiddleName}</p>
                                <p class="text-sm font-semibold text-gray-1000 truncate dark:text-gray-400">RFID #: ${employee.SmartCardID ? employee.SmartCardID : '' }</p>
                            </div>
                            <div class="md:inline-flex gap-5 items-center text-base font-semibold text-gray-900 dark:text-white">
                                
                                <a href="javascript:void(0)" onclick="openEditModal('${employee.EmployeeID}')" data-modal-target="editEmployeeModal" data-modal-toggle="editEmployeeModal"  class="hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor"  
                                        viewBox="0 -960 960 960" class="w-5 h-5">
                                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    `;

                    ul.appendChild(li);
                });

                employeeList.appendChild(ul);
            })
            .catch(error => console.error("Error fetching employees:", error));
        }


        function closeModal() {
            const modal = document.getElementById("editEmployeeModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }

    </script>

@endpush

</x-Main-layout>

