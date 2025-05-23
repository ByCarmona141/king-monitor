@extends('king-monitor::layouts.app')

@section('title')
    {{ config('app.name', 'Monitor Error') }}
@endsection

@section('header')
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ __('Monitor') }}
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mt-4">
                        <div class="flex flex-wrap -mx-6">
                            <div class="w-full px-6 mt-6 sm:w-1/2 sm:mt-6 md:mt-6 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#FFFFFF">
                                            <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">{{$errorStatistics['total']['total']}}</h4>
                                        <div class="text-gray-500">Total Errors</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#FFFFFF">
                                            <path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M4.5 11h-2V9H1v6h1.5v-2.5h2V15H6V9H4.5v2zm2.5-.5h1.5V15H10v-4.5h1.5V9H7v1.5zm5.5 0H14V15h1.5v-4.5H17V9h-4.5v1.5zm9-1.5H18v6h1.5v-2h2c.8 0 1.5-.7 1.5-1.5v-1c0-.8-.7-1.5-1.5-1.5zm0 2.5h-2v-1h2v1z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            @if ($errorStatistics['total']['method']['mostCommon'] !== NULL)
                                                {{$errorStatistics['total']['method']['mostCommon'][0]}}
                                            @else
                                                ANY
                                            @endif
                                        </h4>
                                        <div class="text-gray-500">Error</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Creacion de la grafica del historico total --}}
                    <div class="grid grid-cols-1 pt-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-4">
                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Historical Total</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="historical-total" width="400" height="100"></canvas>
                            </div>
                        </div>

                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <!-- Card header -->
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Total Method</h4>
                            </div>
                            <!-- Chart -->
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="total-method" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Creacion de la grafica del historico year --}}
                    <div class="grid grid-cols-1 pt-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-4">
                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Historical Year</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="historical-year" width="400" height="100"></canvas>
                            </div>
                        </div>

                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Historical Exceeded Year</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="historical-exceeded-year" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex flex-wrap -mx-6">
                            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg height="36px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 7C20 8.65685 18.6569 10 17 10C15.3431 10 14 8.65685 14 7C14 5.34315 15.3431 4 17 4C18.6569 4 20 5.34315 20 7Z" fill="currentColor"/>
                                            <path d="M12 6H4V20H18V12H16V18H6V8H12V6Z" fill="currentColor"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            {{$statisticsAlert['total']}}
                                        </h4>
                                        <div class="text-gray-500">Total Alert</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0 md:mt-0 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg height="36px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="32" cy="24" r="16" fill="none"/>
                                            <path d="M32 4c-11.05 0-20 8.95-20 20 0 14 20 36 20 36s20-22 20-36c0-11.05-8.95-20-20-20zm0 28c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" fill="currentColor"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            @if ($statisticsAlert['ip'] !== NULL)
                                                {{$statisticsAlert['ip'][0]}}
                                            @else
                                                ANY
                                            @endif
                                        </h4>
                                        <div class="text-gray-500">IP</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-6 md:mt-6 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#FFFFFF">
                                            <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">{{$errorStatisticsExceeded['total']['total']}}</h4>
                                        <div class="text-gray-500">Total Exceeded Errors</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const historicalTotal = document.getElementById('historical-total');
        const historicalYear = document.getElementById('historical-year');
        const totalMethod = document.getElementById('total-method');
        const historicalExceededYear = document.getElementById('historical-exceeded-year');

        let tag = new Set();
        var error = [];

        @foreach ($errorHistorical['total']['details'] as $error)
            error.push({"year":"{{$error['year']}}", "total":"{{$error['total']}}"});
        @endforeach

        // Obtenemos los años en cada arreglo
        error.forEach(item => tag.add(item.year));

        // Convertimos el set a un array
        tag = Array.from(tag);

        // Ordenar los arreglos por año para mantenerlos organizados
        error.sort((a, b) => a.year - b.year);
        tag.sort();

        // Separar los totales de peticiones y errores
        let totalError = error.map(item => item.total);

        new Chart(historicalTotal, {
            type: 'line',
            data: {
                labels: tag,
                datasets: [{
                    label: 'Error',
                    data: totalError,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                responsive: true,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        });

        let tag2 = new Set();
        let error2 = [];

        @foreach ($errorHistorical['year']['details'] as $error)
            error2.push({"month":"{{$error['month']}}", "total":"{{$error['total']}}"});
        @endforeach

        // Obtenemos los meses en cada arreglo
        error2.forEach(item => tag2.add(item.month));

        // Convertimos el set a un array
        tag2 = Array.from(tag2);

        // Ordenar los arreglos por año para mantenerlos organizados
        error2.sort((a, b) => a.month - b.month);
        tag2.sort();

        // Separar los totales de peticiones y errores
        let totalError2 = error2.map(item => item.total);

        new Chart(historicalYear, {
            type: 'radar',
            data: {
                labels: tag2,
                datasets: [{
                    label: 'Error',
                    data: totalError2,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                responsive: true,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        });

        new Chart(totalMethod, {
            type: 'bar',
            data: {
                labels: ['GET', 'POST', 'PUT', 'DELETE'],
                datasets: [{
                    label: 'Error',
                    data: [
                        {{ $errorStatistics['year']['method']['GET'] }},
                        {{ $errorStatistics['year']['method']['POST'] }},
                        {{ $errorStatistics['year']['method']['PUT'] }},
                        {{ $errorStatistics['year']['method']['DELETE'] }},
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 99, 132)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
            }
        });

        let tag3 = new Set();
        var error3 = [];

        @foreach ($errorHistoricalExceeded['year']['details'] as $error)
            error3.push({"month":"{{$error['month']}}", "total":"{{$error['total']}}"});
        @endforeach

        // Obtenemos los meses en cada arreglo
        error3.forEach(item => tag3.add(item.month));

        // Convertimos el set a un array
        tag3 = Array.from(tag3);

        // Ordenar los arreglos por año para mantenerlos organizados
        error3.sort((a, b) => a.month - b.month);
        tag3.sort();

        // Separar los totales de peticiones y errores
        let totalError3 = error3.map(item => item.total);

        new Chart(historicalExceededYear, {
            type: 'line',
            data: {
                labels: tag3,
                datasets: [{
                    label: 'Error',
                    data: totalError3,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    pointBackgroundColor: 'rgb(255, 99, 132)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(255, 99, 132)'
                }]
            },
            options: {
                responsive: true,
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            }
        });
    </script>
@endsection