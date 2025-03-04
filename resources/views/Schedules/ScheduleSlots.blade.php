<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('scheduleSlots.index')}}" class="ms-1 text-md font-small md:text-lg md:font-medium  text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">SCHEDULES - Slots</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10 mb-10 ">
            <div id="displayCards" class="flex gap-5 lg:gap-10">
                {{-- <x-Cards.ResultCards /> --}}
            </div>

            <label class="block text-md text-gray-700  dark:text-gray-300">FILTER: </label>
            <hr class="my-2 mx-2">
            <div class="grid grid-cols-2 lg:grid-cols-4 mb-2">
                <div class="dark:text-gray-200 mx-2 ">
                    <label for="termID" class="block text-md text-gray-700  dark:text-gray-300">Term </label>
                    <select id="termID" name="termID" onchange="getDataByTerm()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                        @foreach ($terms as $term)
                            <option value="{{ $term->TermID }}">({{ $term->TermID }}) &nbsp; {{ $term->AcademicYear }} &nbsp;&nbsp;{{ $term->SchoolTerm }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center mt-5 ms-5">
                    <input type="checkbox" id="isVacant" onchange="getDataByVacant()" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-600 dark:ring-offset-gray-800 dark:focus:ring-blue-500">
                    <label for="isVacant" class="ms-2 text-gray-700 dark:text-gray-300 text-sm">Available</label>
                    <input type="checkbox" id="inActive" onchange="getDataByActive()" class="ms-5  w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-slate-800 dark:border-gray-600 dark:ring-offset-gray-800 dark:focus:ring-blue-500">
                    <label for="inActive" class="ml-2 text-gray-700 dark:text-gray-300 text-sm">Inactive</label>
                </div>
            </div>
            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 mb-10">
                <div class="dark:text-gray-200 mx-2 mb-2">
                    <div class="rounded-lg">
                        <label for="centerID" class="block text-md text-gray-700  dark:text-gray-300">Center</label>
                        <select id="centerID" name="centerID" onchange="getDateByCenter()" onclick="getDataByCenter()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                            <option value="0">All </option>
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->testCenterName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="dark:text-gray-200 mx-2 mb-2"> 
                    <div class="rounded-lg">
                        <label for="dateFromID" class="block text-md text-gray-700  dark:text-gray-300">Date From</label>
                        <select id="dateFromID" name="dateFromID" onchange="getDataByDate()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">All </option>
                        </select>
                    </div>
                </div>
                <div class="dark:text-gray-200 mx-2 mb-2"> 
                    <div class="rounded-lg">
                        <label for="dateToID" class="block text-md text-gray-700  dark:text-gray-300">Date To</label>
                        <select id="dateToID" name="dateToID" onchange="getDataByDate()"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">All </option>
                        </select>
                    </div>
                </div>
                <div class="dark:text-gray-200 mx-2 mb-2"> 
                    <div class="rounded-lg">
                        <label for="roomID" class="block text-md text-gray-700  dark:text-gray-300">Room</label>
                        <select id="roomID" name="roomID" onchange="getDataByRoom()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">All </option>
                        </select>
                    </div>
                </div>
            </div>
            
            {{-- <button type="button"  onclick="generateData()" class="mb-4 flex items-center justify-center text-white bg-red-900 hover:bg-red-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 focus:outline-none dark:focus:ring-primary-800">
                <svg aria-hidden="true" class="w-5 h-5 me-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                Generate
            </button> --}}

            <div class="border border-gray-300 rounded-xl p-5">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-2">
                    <div class="w-full lg:w-4/12 justify-start">
                        <form class="flex items-center">
                            <label for="searchInput" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="searchInput" oninput="handleInputChange(event)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                    <div class="w-full lg:w-8/12 md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Columns
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown" class="z-10 hidden w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Columns</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    @foreach(['totalRegistered', 'availableSlots', 'isFull', 'isActive'] as $column)
                                        <li class="flex items-center">
                                            <input type="checkbox" value="{{ $column }}"  onchange="updateColumns(this)" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($column) }}</label>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="rounded-lg">
                            <select id="sort" name="sort" onchange="sortByColumn()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach(['testCenterName', 'testTimeStartString', 'testTimeEndString', 'testSessionName', 'testRoomName', 'totalRegistered', 'availableSlots', 'isFull'] as $sort)
                                        <option value="{{ $sort }}">{{ $sort }} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <button type="button" onclick="exportToExcel()" class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Export
                        </button> --}}
                        
                    </div>
                </div>

                

                <hr class="mx-5">
                <div id="paginationControls" class="flex items-center justify-center space-x-2 my-2">
                    <div class="w-30">
                        <div class="flex items-center">
                            <label for="pageSelect" class="text-gray-700  dark:text-gray-300 mx-1">Page:</label>
                                <select id="pageSelect" onchange="changePage(this.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center w-30">
                        <label for="limitSelect" class="text-gray-700  dark:text-gray-300 mx-1">Limit:</label>
                        <select id="limitSelect" onchange="changeLimit(this.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-center space-x-2 my-2">
                    <div class="w-60 items-center justify-center">
                        <div class="flex items-center justify-center text-center text-gray-700  dark:text-gray-300 mx-1">
                            <p class="text-2xl w-full ms-1" id="totalRows"></p>
                        </div>
                    </div>
                </div>

                <div id="tableContainer" class="overflow-x-auto overflow-y-auto h-100 text-sm border border-gray-300 rounded-lg"></div>
            </div>

            {{-- MODALS --}}
            @include('Layouts.Modal.ScheduleSlots.Edit')
        </div>
    </div>

    @push('scripts')

        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>
        
        <script>
            let selectedColumns = ['id', 'testCenterName', 'testDate', 'testSessionName', 'testTimeStartString', 'testTimeEndString',  'testRoomName',]; 
            let currentPage = 1;
            let pageLimit = 10; 
            let selectedStatus = 'all'; 

            getDataByTerm();


            function handleInputChange(event) {
                const searchValue = event.target.value;
                getDataRows(); 

            }

            // function exportToExcel() {
            //     const filters = {
            //         termID: document.getElementById('termID').value,
            //         centerID: document.getElementById('centerID').value,
            //         dateFromID: document.getElementById('dateFromID').value,
            //         dateToID: document.getElementById('dateToID').value,
            //         search: document.getElementById('searchInput').value,
            //     };

            //     axios.post('/admission/schedule/exportApplicantsScheds', {
            //         columns:  selectedColumns.join(','),
            //         ...filters,
            //     }, {
            //         responseType: 'blob',  
            //     })
            //     .then(response => {
            //         const url = window.URL.createObjectURL(new Blob([response.data]));
            //         const link = document.createElement('a');
            //         link.href = url;
            //         link.setAttribute('download', 'applicantsSchedules-data.xlsx');
            //         document.body.appendChild(link);
            //         link.click();
            //         link.remove();
            //         swalGenericExport();
            //     })
            //     .catch(error => {
            //         console.error('Error exporting to Excel:', error);
            //         swalGenericError('An unexpected error occurred!', error.message || 'Please try again.');
            //     });
            // }

            function updateColumns(checkbox) {
                if (checkbox.checked) {
                    selectedColumns.push(checkbox.value);
                } else {
                    selectedColumns = selectedColumns.filter(column => column !== checkbox.value);
                }
                currentPage = 1;  
                getDataRows();
            }

            function changePage(page) {
                currentPage = page;
                getDataRows();
            }

            function changeLimit(limit) {
                pageLimit = limit;
                currentPage = 1;  
                getDataRows();
            }

            function getDataByTerm() {
                getDateByCenter();
                getRoomData();
                getDataRows();
            }

            function getDataByCenter() {
                getRoomData();
                getDataRows();
            }

            function getDataByDate() {
                getRoomData();
                getDataRows();
            }

            function getDataByRoom() {
                getDataRows();
            }

            function getDataByActive() {
                getDataRows();
            }

            function getDataByVacant() {
                getDataRows();
            }

            function generateData() {
                getDataRows(); 
            }

            function sortByColumn() {
                getDataRows(); 
            }
            
            function getDateByCenter() {
                axios.get('/api/admission/schedule/applicants/getDates', {
                        params: {
                            centerID: document.getElementById('centerID').value,
                            termID: document.getElementById('termID').value,
                        },
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(response => {
                        const dateFromSelect = document.getElementById('dateFromID');
                        dateFromSelect.innerHTML = '<option value="0">All</option>';
                        response.data.forEach(date => {
                            const option = document.createElement('option');
                            // option.value = date.testDateID;
                            option.value = date.testDate;
                            option.text = date.testDate;
                            dateFromSelect.appendChild(option);
                        });

                            
                        const dateToSelect = document.getElementById('dateToID');
                        dateToSelect.innerHTML = '<option value="0">All</option>';
                        response.data.forEach(date => {
                            const option = document.createElement('option');
                            option.value = date.testDate;
                            option.text = date.testDate;
                            dateToSelect.appendChild(option);
                        });

                        // getDataRows(); 
                    })
                    .catch(error => console.error('Error fetching dates:', error));
            }

            function getRoomData() {
                axios.get('/api/admission/schedule/applicants/getRooms', {
                        params: {
                            centerID: document.getElementById('centerID').value,
                            termID: document.getElementById('termID').value,
                            dateFromID: document.getElementById('dateFromID').value,
                            dateToID: document.getElementById('dateToID').value,
                        },
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    }).then(response => {
                        const roomSelect = document.getElementById('roomID');
                        roomSelect.innerHTML = '<option value="0">All</option>';
                        response.data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.testRoomID;
                            option.text = room.testRoomName;
                            roomSelect.appendChild(option);
                        });

                        // getDataRows(); 
                    })
                    .catch(error => console.error('Error fetching dates:', error));
            }

            function getDataRows(page = currentPage, limit = pageLimit) {
                const tableContainer = document.getElementById('tableContainer');
                if (!selectedColumns.length) {
                    tableContainer.innerHTML = "<p>No data found!!</p>";
                    document.getElementById('paginationControls').innerHTML = "";
                    document.getElementById('totalRows').innerHTML = ""; 
                    return;
                }

                axios.get('/api/admission/schedule/slots', {
                    params: {
                        columns: selectedColumns.join(','),
                        page,
                        limit,
                        termID: document.getElementById('termID').value,
                        centerID: document.getElementById('centerID').value,
                        dateFromID: document.getElementById('dateFromID').value,
                        dateToID: document.getElementById('dateToID').value,
                        roomID: document.getElementById('roomID').value,
                        search: document.getElementById('searchInput').value,
                        sort: document.getElementById('sort').value,
                        inActive: document.getElementById('inActive').checked,  
                        isVacant: document.getElementById('isVacant').checked,
                    },
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(({ data }) => {
                    renderTable(data.data, data.current_page, pageLimit);
                    renderPagination(data);
                    document.getElementById('totalRows').textContent = `${data.total.toLocaleString()}`;
                    
                })
                .catch(console.error);
            }


            function renderTable(data, currentPage, limit) {
                let tableHTML = '<table class="min-w-full border border-gray-300 rounded-xl text-gray-700  dark:text-gray-300"><thead><tr>';
                tableHTML += '<th class="py-2 px-4 border">#</th>';  
                selectedColumns.forEach(column => {
                    if (column === "id") { 
                        tableHTML += `<th class="py-2 px-4 border hidden">${column.charAt(0).toUpperCase() + column.slice(1)}</th>`;
                    } else {
                        tableHTML += `<th class="py-2 px-4 border">${column.charAt(0).toUpperCase() + column.slice(1)}</th>`;
                    }
                    
                });
                
                tableHTML += `<th class="py-2 px-4 border">Actions</th>`;
                tableHTML += `</tr></thead><tbody>`;

                data.forEach((row, index) => {
                    let rowNumber = (currentPage - 1) * limit + index + 1; 
                    let rowID = row.id;    

                    tableHTML += `<tr data-id="${rowID}"><td class="py-2 px-4 border">${rowNumber}</td>`;  

                    selectedColumns.forEach(column => {
                        if (column === "id") { 
                            tableHTML += `<td class="hidden">${rowID}</td>`;  
                        } else {
                            tableHTML += `<td class="py-2 px-4 border">${row[column] || ''}</td>`;
                        }
                    });
 
                    tableHTML += `
                        <td class="py-2 px-4 border text-center inline-flex">
                            <a href="javascript:void(0)" onclick="openEditModal('${rowID}')" data-modal-target="editScheduleSlotModal" data-modal-toggle="editScheduleSlotModal" class="hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                </svg>
                            </a>
                            <button onclick="swalDelete('${rowID}')" class="hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                            </button>
                        </td>
                    </tr>`;
                });

                tableHTML += '</tbody></table>';
                document.getElementById('tableContainer').innerHTML = tableHTML;
            }

            
            function openEditModal(id) {
                alert(`Edit record with ID: ${id}`);
                console.log("Slot ID Sent to Axios:", id, typeof id);
                axios.get(`/admission/schedule/scheduleSlots/${id}/edit`)
                    .then(response => {
                        const slot = response.data;
                        document.getElementById('slotID').value = slot.id;
                        document.getElementById('campusID').value = slot.testCenterID;
                        document.getElementById('e_term').value = slot.termID;
                        document.getElementById('e_center').value = slot.testCenterID;
                        document.getElementById('e_date').value = slot.testDateID;
                        document.getElementById('e_time').value = slot.testTimeID;
                        document.getElementById('e_session').value = slot.testSessionID;
                        document.getElementById('e_room').value = slot.testRoomID;
                    })
                    .catch(error => {
                        console.error('Error fetching Schedule Slot data:', error);
                        swalGenericError('An unexpected error occurred!', error);
                    });
                 
            }


            
            // FUNCTION TO DELETE ITEM
            function swalDelete(id) {
                    // alert(`Deleted record with ID: ${id}`);
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
                        axios.delete(`{{ route('scheduleSlots.destroy', '') }}/${id}`, {
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


            function renderPagination(pagination) {
                let pageSelect = document.getElementById('pageSelect');
                pageSelect.innerHTML = ''; 

                for (let page = 1; page <= pagination.last_page; page++) {
                    let option = document.createElement('option');
                    option.value = page;
                    option.text = `${page}`;
                    if (page === pagination.current_page) {
                        option.selected = true;
                    }
                    pageSelect.appendChild(option);
                }
            }

        </script>

    @endpush

</x-Main-layout>

