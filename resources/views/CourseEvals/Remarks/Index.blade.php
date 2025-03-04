<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">Course Evaluation</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5">
            <x-Tabs.CourseEvalTab />
            <div class=" text-gray-900 dark:text-gray-100 mt-3">

                <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100 mt-5  xl:px-5">
                    Remarks
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400  xl:px-5">
                    Remark details of Course Evaluation
                </p>

                <div class="flex justify-end xl:px-5 my-5">
                    <a href="#" id="addRemarkModalButton" data-modal-target="addRemarkModal" data-modal-toggle="addRemarkModal" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                        Add Remarks
                    </a>
                </div>
                <div class="xl:px-5 mb-5">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table  id="main-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead >
                                <tr>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        ID
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        QUESTION
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        ORDER NO.
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        ORDER ALPH.
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        PARAMETER ID
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        EVALTYPE ID
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        PLACEHOLDER
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        STATUS
                                    </th>
                                    <th scope="col"  class="text-md text-gray-800 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                        ACTION
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($remarks as $remark)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm">
                                        <td>
                                            {{ $remark->id }}
                                        </td>
                                        <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="ps-3">
                                                <div class="font-semibold max-w-[24rem] truncate">{{ $remark->question }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $remark->sortOrderN }}
                                        </td>
                                        <td>
                                            {{ $remark->sortOrderA }}
                                        </td>
                                        <td>
                                            {{ $remark->parameterID }}
                                        </td>
                                        <td>
                                            {{ $remark->evalTypeID }}
                                        </td>
                                        <td>
                                            {{ $remark->placeHolder }}
                                        </td>
                                        <td>
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full {{ $remark->isActive ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                                                {{ $remark->isActive ? 'Active' : 'Inactive' }}
                                            </div>
                                        </td>
                                        <td class="flex items-center justify-center space-x-2 pt-5 m-0 h-full mb-0">
                                            <a href="javascript:void(0)" onclick="openEditModal({{ $remark->id }})" data-modal-target="editRemarkModal" data-modal-toggle="editRemarkModal" class="hover:text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                </svg>
                                            </a>
                                            <button onclick="swalDelete({{ $remark->id }})" class="hover:text-red-700 "  >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                </svg>
                                            </button>
                                        </td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            @include('Layouts.Modal.CourseEvalRemarks.Create')
            @include('Layouts.Modal.CourseEvalRemarks.Edit')
        </div>
    </div>


    @push('scripts')

        {{-- DATATABLES --}}
        <script src="{{ asset('JS/Tables/Datatables.js') }}"></script>
        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalUnique.js') }}"></script>
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // FUNCTION ADD ITEM
                var submitFormUrl = "{{ route('courseEvalRemarks.store') }}";
                document.getElementById('addRemarkForm').addEventListener('submit', function(e) {
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


                 // FUNCTION UPDATE ITEM
                 document.getElementById('editRemarkForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const remarkId = document.getElementById('remarkId').value;

                    axios.post(`/courseEvalRemarks/${remarkId}`, formData)
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
            function openEditModal(remarkId) {
                axios.get(`/courseEvalRemarks/${remarkId}/edit`)
                    .then(response => {
                        const item = response.data;
                        document.getElementById('remarkId').value = item.id;
                        document.getElementById('e_question').value = item.question;
                        document.getElementById('e_placeholder').value = item.placeHolder;
                        document.getElementById('e_sortorderN').value = item.sortOrderN;
                        document.getElementById('e_sortorderA').value = item.sortOrderA;
                        document.getElementById('e_parameterID').value = item.parameterID;
                        document.getElementById('e_evaltypeID').value = item.evalTypeID;
                        document.getElementById('e_status').value = item.isActive;
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
                    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.action = `{{ route('courseEvalRemarks.destroy', '') }}/${id}`;
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


            // FUNCTION TO CLOSE MODALS
            function closeAddModal() {
                document.getElementById('addRemarkModal').classList.add('hidden');
                document.getElementById('errorMessage').innerHTML = '';
            }
            function closeEditModal() {
                document.getElementById('editRemarkModal').classList.add('hidden');
                document.getElementById('e_errorMessage').innerHTML = '';
            }

        </script>
    @endpush

</x-Main-layout>

