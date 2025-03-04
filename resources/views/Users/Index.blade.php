<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">USERS</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10">
            <div class="md:p-6 text-gray-900 dark:text-gray-100">

                <h1 class="text-3xl font-medium text-gray-800 dark:text-gray-100">
                    Users List
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    User ID, Full Name, Email Address, Account Type and Status.
                </p>

                <div class="flex justify-end px-5 ">
                    <a href="#" id="addUserModalButton" data-modal-target="addUserModal" data-modal-toggle="addUserModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                        Add User
                    </a>
                </div>
                <div class="relative overflow-x-auto mt-5 shadow-md rounded-lg border-2 dark:border-gray-500">
                    <div class="p-5">
                        <table id="Tabledata" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FullName</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <img class="w-8 h-8 rounded-full" src="{{ $user->Photo_base64 ? $user->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                            <span style="vertical-align: middle; display: inline-block; margin-left:10px;">
                                                {{ $user->name }}
                                            </span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="flex items-center">
                                                {{ $user->type ? 'Admin' : 'User' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full {{ $user->status ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                {{ $user->status ? 'Active' : 'Inactive' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center space-x-4">
                                                <a href="javascript:void(0)" onclick="openEditModal({{ $user->id }})" data-modal-target="editUserModal" data-modal-toggle="editUserModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                    </svg>
                                                </a>
                                                <a href="javascript:void(0)" onclick="openPasswordModal({{ $user->id }})" data-modal-target="editPasswordModal" data-modal-toggle="editPasswordModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" height="24px" viewBox="0 -960 960 960" width="24px" fill="#434343">
                                                        <path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/>
                                                    </svg>
                                                </a>
                                                <button onclick="swalDelete({{ $user->id }})" class="hover:text-red-700 "  >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>FullName</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @include('Layouts.Modal.Users.Create')
            @include('Layouts.Modal.Users.Edit')
            @include('Layouts.Modal.Users.Password')
        </div>
    </div>

    @push('scripts')

        {{-- DATATABLES --}}
        <script>
            new DataTable('#Tabledata', {
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },
                order: [[0, 'asc']]
            });
        </script>


        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalUnique.js') }}"></script>
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>

        {{-- MODAL --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // AXIOS ADD USER
                var submitFormUrl = "{{ route('users.store') }}";
                document.getElementById('addUserForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    axios.post(submitFormUrl, formData)
                        .then(response => {
                            closeAddModal();
                            this.reset();
                            document.getElementById('errorMessage').innerHTML = '';
                            swalGenericAdd(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('errorMessage');
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

                // AXIOS UPDATE USER
                document.getElementById('editUserForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const userId = document.getElementById('userId').value;

                    axios.post(`/users/${userId}`, formData)
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
                                swalGenericError('An unexpected error occurred!',errorMsg);
                            }
                        });
                });


                // AXIOS RESET PASSWORD
                document.getElementById('editPasswordForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const userIdPw = document.getElementById('userIdPw').value;

                    axios.post(`/user/resetPassword`, formData)
                        .then(response => {
                            closePasswordModal();
                            this.reset();
                            document.getElementById('p_errorMessage').innerHTML = '';
                            swalGenericUpdate(response.data.message);
                        })
                        .catch(error => {
                            if (error.response && error.response.status === 422) {
                                const errors = error.response.data.errors;
                                const errorList = document.getElementById('p_errorMessage');
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


            // FUNCTION TO SHOW USER TO EDIT
            function openEditModal(userId) {
                axios.get(`/users/${userId}/edit`)
                    .then(response => {
                        const user = response.data;
                        document.getElementById('userId').value = user.id;
                        document.getElementById('e_name').value = user.name;
                        document.getElementById('e_email').value = user.email;
                        document.getElementById('e_type').value = user.type;
                        document.getElementById('e_status').value = user.status;

                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        swalGenericError('An unexpected error occurred!',error);
                    });
            }


            // FUNCTION TO SHOW PASSWORD TO EDIT
            function openPasswordModal(userId) {
                axios.get(`/users/${userId}/edit`)
                    .then(response => {
                        const user = response.data;
                        document.getElementById('userIdPw').value = user.id;
                        document.getElementById('p_name').value = user.name;
                        document.getElementById('p_email').value = user.email;
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        swalGenericError('An unexpected error occurred!',error);
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
                    cancelButtonText: 'No, Cancel',
                    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`{{ route('users.destroy', '') }}/${id}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => {
                            if (response.data.status === 'success') {
                                swalGenericDelete(response.data.message);
                                location.reload(); 
                            } else {
                                swalGenericError('Invalid Deletion!',response.data.message);
                                location.reload(); 
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

            // FUNCTION TO CLOSE MODALS
            function closeAddModal() {
                document.getElementById('addUserModal').classList.add('hidden');
                document.getElementById('errorMessage').innerHTML = '';
            }
            function closeEditModal() {
                document.getElementById('editUserModal').classList.add('hidden');
                document.getElementById('e_errorMessage').innerHTML = '';
            }
            function closePasswordModal() {
                document.getElementById('editPasswordModal').classList.add('hidden');
                document.getElementById('p_errorMessage').innerHTML = '';
            }

        </script>

    @endpush

</x-Main-layout>

