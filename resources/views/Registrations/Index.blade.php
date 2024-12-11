<x-Main-layout>
    @if (session('success'))
        <x-Alert-success>
            {{ session('success') }}
        </x-Alert-success>
    @endif

    <x-Breadcrumbs>
        <a  href="{{route('registers.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">REGISTRATIONS</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="overflow-hidden py-5">
            <div id="genderCounts" class="flex gap-4 mt-4">
                
            </div>

            <div class="mb-4">
                <h1 class="text-xl font-bold mb-2">Select Columns to Display</h1>
                <div class="flex gap-2">
                    {{-- <label class="inline-flex items-center">
                        <input type="checkbox" value="Fullname" class="form-checkbox" checked onchange="toggleFullnameColumn(this)">
                        <span class="ml-2">Fullname</span>
                    </label> --}}
                    @foreach(['AppNo', 'AppDate', 'Gender', 'IsValidated', 'isInvalid'] as $column)
                        <label class="inline-flex items-center">
                            <input type="checkbox" value="{{ $column }}" class="form-checkbox" onchange="updateColumns(this)">
                            <span class="ml-2">{{ ucfirst($column) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                <form id="filterForm">
                    <label>
                        <input type="radio" name="gender" id="filterMale" value="M" onclick="filterByGender(this.value)"> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" id="filterFemale" value="F" onclick="filterByGender(this.value)"> Female
                    </label>
                    <label>
                        <input type="radio" name="gender" id="filterAll" value="all" onclick="filterByGender(this.value)" > All
                    </label>
                </form>
            </div>

            <div id="paginationControls" class="flex items-center justify-center mt-4 space-x-2">
                <label for="pageSelect" class="mr-2 font-semibold">Page:</label>
                <select id="pageSelect" onchange="changePage(this.value)" class="border px-4 py-2 rounded">

                </select>




                <div class="flex items-center space-x-2">
                    <label for="limitSelect" class="mr-2 font-semibold">Show:</label>
                    <select id="limitSelect" onchange="changeLimit(this.value)" class="border px-4 py-2 rounded">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </select>
                </div>
            </div>
            <div id="totalRows" class="mb-4 font-semibold text-lg"></div>
            <div id="tableContainer" class="overflow-x-auto mt-4"></div>


        </div>
    </div>

    @push('scripts')

        {{-- DATATABLES --}}
        <script>
            let selectedColumns = ['LastName', 'FirstName', 'MiddleName']; // Default columns for "Fullname"
            let currentPage = 1;
            let pageLimit = 10; // Default page limit
            let selectedGender = 'all'; // Default to show all genders

            function updateColumns(checkbox) {
                if (checkbox.checked) {
                    selectedColumns.push(checkbox.value);
                } else {
                    selectedColumns = selectedColumns.filter(column => column !== checkbox.value);
                }
                currentPage = 1; // Reset to first page when columns change
                fetchData();
            }

            function changePage(page) {
                currentPage = page;
                fetchData();
            }

            function changeLimit(limit) {
                pageLimit = limit;
                currentPage = 1; // Reset to the first page on limit change
                fetchData();
            }

            function filterByGender(gender) {
                selectedGender = gender;
                currentPage = 1; // Reset to first page when filter changes
                fetchData(); // Fetch data based on the selected gender filter
            }

            function fetchData(page = currentPage, limit = pageLimit) {
                if (selectedColumns.length === 0) {
                    document.getElementById('tableContainer').innerHTML = "<p>Select at least one column to display data.</p>";
                    document.getElementById('paginationControls').innerHTML = ""; // Clear pagination if no columns selected
                    document.getElementById('totalRows').innerHTML = ""; // Clear total rows if no columns selected
                    return;
                }

                axios.get('/api/dataRegistrations', {
                    params: {
                        columns: selectedColumns.join(','),
                        page: page,
                        limit: limit,
                        gender: selectedGender !== 'all' ? selectedGender : null,
                    },
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(response => {
                    renderTable(response.data.data, response.data.current_page, pageLimit);
                    renderPagination(response.data);
                    renderGenderCounts(response.data.counts);
                    document.getElementById('totalRows').innerHTML = `Total rows: ${response.data.total}`;
                })
                .catch(error => console.error(error));
            }

            function renderGenderCounts(counts) {
                const genderCountsContainer = document.getElementById('genderCounts');
                genderCountsContainer.innerHTML = '';

                if (selectedGender === 'M') {
                    genderCountsContainer.innerHTML = `
                        <div class="flex space-x-4 mb-4">
                            <div class="bg-gradient-to-r from-emerald-400 to-cyan-400 text-gray-700 rounded-lg shadow-md p-6">
                                <div class="flex items-center">
                                    <div class="text-gray-700 rounded-lg shadow-md p-6">
                                        <div class="flex items-center">
                                            <div class="p-2  rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m-4-4v8m-2.879-6.879a3 3 0 114.243 4.243L16 16m-4-4l-4 4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-lg font-semibold">Male</h2>
                                                <p class="text-2xl font-bold">${counts.male}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                } else if (selectedGender === 'F') {
                    genderCountsContainer.innerHTML = `
                        <div class="flex space-x-4 mb-4">
                            <div class="bg-gradient-to-r from-emerald-400 to-cyan-400 text-gray-700 rounded-lg shadow-md p-6">
                                <div class="flex items-center">
                                    <div class="text-gray-700 rounded-lg shadow-md p-6">
                                        <div class="flex items-center">
                                            <div class="p-2  rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 7a4 4 0 118 0c0 1.07-.268 2.07-.743 2.936M12 11h.01M16.334 14.64A5 5 0 0117 18a5 5 0 11-10 0 5 5 0 01.646-2.36M12 11v5" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-lg font-semibold">Female</h2>
                                                <p class="text-2xl font-bold">${counts.female}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                } else {
                    genderCountsContainer.innerHTML = `
                        <div class="flex space-x-4 mb-4">
                            <div class="bg-gradient-to-r from-emerald-400 to-cyan-400 text-gray-700 rounded-lg shadow-md p-6">
                                <div class="flex items-center text-center ">
                                    <p class="items-center text-center text-lg font-bold w-full">TOTAL</p> 
                                </div>
                                <div class="flex items-center text-center ">
                                    <p class="items-center text-center text-2xl font-bold w-full">${counts.total}</p>
                                </div>
                                <div class="flex items-center">
                                    <div class="text-gray-700 rounded-lg shadow-md p-6">
                                        <div class="flex items-center">
                                            <div class="p-2  rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m-4-4v8m-2.879-6.879a3 3 0 114.243 4.243L16 16m-4-4l-4 4" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-lg font-semibold">Male</h2>
                                                <p class="text-2xl font-bold">${counts.male}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-gray-700 rounded-lg shadow-md p-6">
                                        <div class="flex items-center">
                                            <div class="p-2  rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 7a4 4 0 118 0c0 1.07-.268 2.07-.743 2.936M12 11h.01M16.334 14.64A5 5 0 0117 18a5 5 0 11-10 0 5 5 0 01.646-2.36M12 11v5" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-lg font-semibold">Female</h2>
                                                <p class="text-2xl font-bold">${counts.female}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }


            function renderTable(data, currentPage, limit) {
                let tableHTML = '<table class="min-w-full bg-white"><thead><tr>';
                tableHTML += '<th class="py-2 px-4 border">#</th>';  
                selectedColumns.forEach(column => {
                    tableHTML += `<th class="py-2 px-4 border">${column.charAt(0).toUpperCase() + column.slice(1)}</th>`;
                });
                tableHTML += '</tr></thead><tbody>';

                data.forEach((row, index) => {
                    let rowNumber = (currentPage - 1) * limit + index + 1; // Row Numbers
                    tableHTML += `<tr><td class="py-2 px-4 border">${rowNumber}</td>`; // Row Number Cells
                    selectedColumns.forEach(column => {
                        if (column === 'Gender') {
                            tableHTML += `<td class="py-2 px-4 border">${row[column] === 'M' ? 'Male' : 'Female'}</td>`; 
                        } else {
                            tableHTML += `<td class="py-2 px-4 border">${row[column] || ''}</td>`;
                        }
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
                    option.text = `Page ${page}`;
                    if (page === pagination.current_page) {
                        option.selected = true;
                    }
                    pageSelect.appendChild(option);
                }
            }


        </script>

    @endpush

</x-Main-layout>

