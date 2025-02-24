<x-Main-layout>
    <div class="py-5 ">
        <x-Breadcrumbs>
            <a  href="{{route('employeesRFIDs.index')}}" class="ms-1 text-lg font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">EMPLOYEES</a>
        </x-Breadcrumbs>

        {{-- <x-Table>
            <table class="w-full text-xs md:text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs md:text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-1 py-3">
                            Employee ID
                        </th>
                        <th scope="col" class="px-1 py-3">
                            FullName - Email
                        </th>
                        <th scope="col" class="px-1 py-3">
                            SmartCard ID
                        </th>
                        <th scope="col" class="px-1 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-1 py-4">
                                {{ $employee->EmployeeID }}
                            </td>
                            <th scope="row" class="flex items-center px-1 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="{{ $employee->Photo_base64 ? $employee->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        {{ $employee->Prefix }} {{ $employee->LastName }}, {{ $employee->FirstName }} {{ $employee->MiddleName }}
                                    </div>
                                    <div class="font-normal text-gray-500">{{ $employee->Email }}</div>
                                </div>
                            </th>
                            <td class="px-1 py-4">
                                {{ $employee->SmartCardID }}
                            </td>
                            <td class="px-1 py-4 space-x-1 inline-flex items-center">
                                <a href="{{ route('employees.show', $employee->EmployeeID)}}" class="font-medium text-gray-600 dark:text-gray-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-Table> --}}

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-5 px-2">
                <div class="p-6 md:p-10 text-gray-900 dark:text-gray-100  ">

                    <h1 class="text-3xl font-medium text-gray-900 dark:text-gray-100">
                        Employees List
                    </h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Employee ID, Full Name, Email Address, SmartCard ID and Status.
                    </p>

                    <div class="flex justify-end px-5 ">
                        <a href="{{ route('employeesRFIDs.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-800 hover:bg-red-900 rounded-lg focus:outline-none focus:ring-1 focus:ring-offset-1">
                            Search
                        </a>
                    </div>

                    <div class="relative overflow-x-auto mt-5 shadow-md sm:rounded-lg border-2">
                        <div class="p-5 ">
                            <table id="Tabledata" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>FullName - Email</th>
                                        <th>Email</th>
                                        <th>SmartCard ID</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->EmployeeID }}</td>
                                            <td>
                                                <img class="w-10 h-10 rounded-full" src="{{ $employee->Photo_base64 ? $employee->Photo_base64 : asset('img_assets/avatar.png') }}" alt="Image" style="vertical-align: middle; display: inline-block;">
                                                <span style="vertical-align: middle; display: inline-block; margin-left:10px;">
                                                    {{ $employee->LastName }}, {{ $employee->FirstName }} {{ $employee->MiddleName }}
                                                </span>
                                            </td>
                                            <td>{{ $employee->Email }}</td>
                                            <td>{{ $employee->SmartCardID }}</td>
                                            <td>
                                                <a href="{{ route('employeesRFIDs.show', $employee->EmployeeID)}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentcolor" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Student No</th>
                                        <th>FullName</th>
                                        <th>Email</th>
                                        <th>SmartCard ID</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            new DataTable('#Tabledata', {
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(3)'
                },
                order: [[1, 'asc']]
            });



            // let data = [];
            // for (let i = 0; i < 50000; i++) {
            //     data.push([i, i, i, i, i]);
            // }

            // new DataTable('#Tabledata', {
            //      data: data,
            //     scrollCollapse: true,
            //     scroller: true,
            //     scrollY: 200,
            //     order: [[1, 'asc']]
            // });
        </script>
    @endpush

</x-Main-layout>

