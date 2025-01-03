<x-Main-layout>
    <x-Breadcrumbs>
        <a  href="{{route('users.index')}}" class="text-lg font-medium text-gray-700  hover:text-red-900 dark:text-gray-400 dark:hover:text-white">Course Evaluation</a>
    </x-Breadcrumbs>
    <div class="mx-auto h-full">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">Course Evaluation</h1>

            <form   method="POST">
                @csrf

                @php
                    $paramCount = 0;
                @endphp

                @foreach($parameters as $parameter)
                    @php
                        $paramCount++;
                        $statementCount = 0;
                    @endphp
                    <div class="mb-10 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                            {{ chr(64 + $paramCount) }}. {{ $parameter->name }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $parameter->desc }}</p>

                        @foreach($statements[$parameter->id] ?? [] as $statement)
                            @php
                                $statementCount++;
                            @endphp
                            <div class="mb-6 p-4 bg-white dark:bg-gray-700 rounded-lg shadow">
                                <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">
                                    {{ $paramCount }}.{{ $statementCount }} {{ $statement->statement }}
                                </h3>

                                @foreach($ratings[$statement->ratingTemplateID] ?? [] as $rating)
                                    <div class="flex items-center mb-2">
                                        <input
                                            type="radio"
                                            name="answers[{{ $statement->id }}]"
                                            id="choice-{{ $rating->id }}"
                                            value="{{ $rating->id }}"
                                            class="hidden peer">
                                        <label for="choice-{{ $rating->id }}" class="flex items-center gap-2 cursor-pointer p-4 border rounded-lg peer-checked:bg-blue-500 peer-checked:text-white dark:border-gray-600 dark:peer-checked:bg-blue-400">
                                            <span class="w-4 h-4 inline-block border border-gray-400 dark:border-gray-500 rounded-full"></span>
                                            <span class="text-gray-800 dark:text-gray-200">{{ $rating->description }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        @foreach($remarks[$parameter->id] ?? [] as $remark)
                            <div class="mb-6 p-4 bg-white dark:bg-gray-700 rounded-lg shadow">
                                <label class="block text-gray-900 dark:text-gray-100 mb-2">{{ $remark->question }}</label>
                                <input
                                    type="text"
                                    name="remarks[{{ $remark->id }}]"
                                    class="w-full p-2 border rounded-lg dark:bg-gray-800 dark:text-gray-200"
                                    placeholder="{{ $remark->placeHolder }}">
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="text-center mt-8">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold dark:bg-blue-500 dark:hover:bg-blue-600">Submit</button>
                </div>
            </form>
        </div>
    </div>
</x-Main-layout>

