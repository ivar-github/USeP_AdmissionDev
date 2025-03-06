<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('schedules.applicants')}}" class="ms-1 text-md font-small md:text-lg md:font-medium  text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">SCHEDULES - Applicants</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5 lg:py-10 mb-10 ">
            <div id="displayCards" class="flex gap-5 lg:gap-10">
                {{-- <x-Cards.ResultCards /> --}}
            </div>

            <label class="block text-md text-gray-700  dark:text-gray-300">FILTER: </label>
            <hr class="my-2 mx-2">
            <div class="grid lg:grid-cols-4 grid-cols-1 mb-2">
                <div class="dark:text-gray-200 mx-2 mb-2">
                    <label for="termID" class="block text-md text-gray-700  dark:text-gray-300">Term </label>
                    <select id="termID" name="termID" onchange="getDataByTerm()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> 
                        @foreach ($terms as $term)
                            <option value="{{ $term->TermID }}">({{ $term->TermID }}) &nbsp; {{ $term->AcademicYear }} &nbsp;&nbsp;{{ $term->SchoolTerm }}</option>
                        @endforeach
                    </select>
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
                        <select id="dateToID" name="dateToID" onchange="getDataByDate()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
            
            <div class="flex justify-end items-center my-2"> 
                {{-- <button type="button"  onclick="generateData()" class="flex items-center justify-center text-white bg-red-900 hover:bg-red-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-900 dark:hover:bg-red-800 focus:outline-none dark:focus:ring-primary-800">
                    <svg aria-hidden="true" class="w-5 h-5 me-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Generate
                </button> --}}
             
                <button type="button" onclick="exportToExcel()" class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-primary-800">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Export
                </button>
            </div>

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
                                    @foreach(['termID', 'appDate', 'testSessionName', 'testRoomName'] as $column)
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
                                <option value="" disabled selected>Sort</option>        
                                <option value="" selected>None</option>    
                                @foreach(['appNo', 'Name', 'appDate', 'testCenterName', 'testDate', 'testTime', 'testSessionName', 'testRoomName'] as $sort)    
                                    <option value="{{ $sort }}">{{ $sort }} </option>
                                @endforeach
                            </select>
                        </div>
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

        </div>
    </div>

    @push('scripts')

        {{-- SWEETALERTS --}}
        <script src="{{ asset('JS/SweetAlerts/SwalGeneric.js') }}"></script>
        
        <script>
            let selectedColumns = ['appNo', 'Name', 'testCenterName', 'testDate', 'testTime' ]; 
            let currentPage = 1;
            let pageLimit = 10; 
            let selectedStatus = 'all'; 

            getDataByTerm();


            function handleInputChange(event) {
                const searchValue = event.target.value;
                getDataRows(); 

            }

            function exportToExcel() {
                const filters = {
                    termID: document.getElementById('termID').value,
                    centerID: document.getElementById('centerID').value,
                    dateFromID: document.getElementById('dateFromID').value,
                    dateToID: document.getElementById('dateToID').value,
                    roomID: document.getElementById('roomID').value,
                    sort: document.getElementById('sort').value,
                    search: document.getElementById('searchInput').value,
                };

                axios.post('/admission/schedule/exportApplicantsScheds', {
                    columns:  selectedColumns.join(','),
                    ...filters,
                }, {
                    responseType: 'blob',  
                })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'applicantsSchedules-data.xlsx');
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    swalGenericExport();
                })
                .catch(error => {
                    swalGenericError('An unexpected error occurred!', error.message || 'Please try again.');
                });
            }

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

                axios.get('/api/admission/schedule/applicants', {
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
                    tableHTML += `<th class="py-2 px-4 border">${column.charAt(0).toUpperCase() + column.slice(1)}</th>`;
                });
                tableHTML += '</tr></thead><tbody>';

                data.forEach((row, index) => {
                    let rowNumber = (currentPage - 1) * limit + index + 1; 
                    tableHTML += `<tr><td class="py-2 px-4 border">${rowNumber}</td>`; 
                    selectedColumns.forEach(column => {

                        tableHTML += `<td class="py-2 px-4 border">${row[column] || ''}</td>`;

                    });
                    tableHTML += '</tr>';
                });

                tableHTML += '</tbody></table>';
                document.getElementById('tableContainer').innerHTML = tableHTML;
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

