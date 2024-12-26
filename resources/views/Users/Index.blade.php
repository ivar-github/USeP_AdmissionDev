<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">USERS</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5">
            <div class="md:p-6 text-gray-900 dark:text-gray-100  ">

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
                                            <img class="w-10 h-10 rounded-full" src="{{ $user->Photo_base64 ? $user->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
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
                                            <a href="javascript:void(0)" onclick="openEditModal({{ $user->id }})" data-modal-target="editUserModal" data-modal-toggle="editUserModal" >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                            </a>
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
                                swalGenericError('An unexpected error occurred!',error);
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

            // FUNCTION TO CLOSE MODALS
            function closeAddModal() {
                document.getElementById('addUserModal').classList.add('hidden');
                document.getElementById('errorMessage').innerHTML = '';
            }
            function closeEditModal() {
                document.getElementById('editUserModal').classList.add('hidden');
                document.getElementById('e_errorMessage').innerHTML = '';
            }

        </script>

    @endpush

</x-Main-layout>

