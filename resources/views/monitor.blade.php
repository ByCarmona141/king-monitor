@extends('king-monitor::layouts.app')

@section('title')
    {{ config('app.name', 'Monitor') }}
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
                            <div class="w-full px-6 sm:w-1/2 xl:w-1/4">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#FFFFFF">
                                            <path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            {{$statistics['request']['total']['total']}}
                                        </h4>
                                        <div class="text-gray-500">Total Request</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-0 md:mt-0 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#FFFFFF">
                                            <path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M4.5 11h-2V9H1v6h1.5v-2.5h2V15H6V9H4.5v2zm2.5-.5h1.5V15H10v-4.5h1.5V9H7v1.5zm5.5 0H14V15h1.5v-4.5H17V9h-4.5v1.5zm9-1.5H18v6h1.5v-2h2c.8 0 1.5-.7 1.5-1.5v-1c0-.8-.7-1.5-1.5-1.5zm0 2.5h-2v-1h2v1z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            @if ($statistics['request']['total']['method']['mostCommon'] !== NULL)
                                                {{$statistics['request']['total']['method']['mostCommon'][0]}}
                                            @else
                                                ANY
                                            @endif
                                        </h4>
                                        <div class="text-gray-500">Request</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-6 md:mt-6 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#FFFFFF">
                                            <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">{{$statistics['errors']['total']['total']}}</h4>
                                        <div class="text-gray-500">Total Errors</div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 0 24 24" width="36px" fill="#FFFFFF">
                                            <path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M4.5 11h-2V9H1v6h1.5v-2.5h2V15H6V9H4.5v2zm2.5-.5h1.5V15H10v-4.5h1.5V9H7v1.5zm5.5 0H14V15h1.5v-4.5H17V9h-4.5v1.5zm9-1.5H18v6h1.5v-2h2c.8 0 1.5-.7 1.5-1.5v-1c0-.8-.7-1.5-1.5-1.5zm0 2.5h-2v-1h2v1z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            @if ($statistics['errors']['total']['method']['mostCommon'] !== NULL)
                                                {{$statistics['errors']['total']['method']['mostCommon'][0]}}
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
                        <div class="col-span-1 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Historical Year</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="historical-year" width="400" height="100"></canvas>
                            </div>
                        </div>

                        <div class="col-span-1 bg-white rounded-md dark:bg-gray-900">
                            <!-- Card header -->
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Year</h4>
                            </div>
                            <!-- Chart -->
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="total" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>

                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Historical Year</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="historical-year" width="400" height="100"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- Card con las graficas de los metodos --}}
{{--                    <div class="grid grid-cols-1 pt-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-3">--}}
{{--                        <div class="grid grid-cols-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">--}}
{{--                            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="today-tab" data-tabs-target="#todayChart" type="button" role="tab" aria-controls="todayChart" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">Today</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="week-tab" data-tabs-target="#weekChart" type="button" role="tab" aria-controls="weekChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Week</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="month-tab" data-tabs-target="#monthChart" type="button" role="tab" aria-controls="monthChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Month</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="year-tab" data-tabs-target="#yearChart" type="button" role="tab" aria-controls="yearChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Year</button>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                            <div id="defaultTabContent">--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="todayChart" role="tabpanel" aria-labelledby="today-tab">--}}
{{--                                    <canvas id="today" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="weekChart" role="tabpanel" aria-labelledby="week-tab">--}}
{{--                                    <canvas id="week" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="monthChart" role="tabpanel" aria-labelledby="month-tab">--}}
{{--                                    <canvas id="month" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="yearChart" role="tabpanel" aria-labelledby="year-tab">--}}
{{--                                    <canvas id="year" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-span-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">--}}
{{--                            <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="today-method-tab" data-tabs-target="#todayMethodChart" type="button" role="tab" aria-controls="todayMethodChart" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">Today</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="week-method-tab" data-tabs-target="#weekMethodChart" type="button" role="tab" aria-controls="weekMethodChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Week</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="month-method-tab" data-tabs-target="#monthMethodChart" type="button" role="tab" aria-controls="monthMethodChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Month</button>--}}
{{--                                </li>--}}
{{--                                <li class="me-2">--}}
{{--                                    <button id="year-method-tab" data-tabs-target="#yearMethodChart" type="button" role="tab" aria-controls="yearMethodChart" aria-selected="false" class="inline-block p-4 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-300">Year</button>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                            <div id="defaultTabContent">--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="todayMethodChart" role="tabpanel" aria-labelledby="today-method-tab">--}}
{{--                                    <canvas id="today-method" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="weekMethodChart" role="tabpanel" aria-labelledby="week-method-tab">--}}
{{--                                    <canvas id="week-method" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="monthMethodChart" role="tabpanel" aria-labelledby="month-method-tab">--}}
{{--                                    <canvas id="month-method" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="yearMethodChart" role="tabpanel" aria-labelledby="year-method-tab">--}}
{{--                                    <canvas id="year-method" width="379" height="256" style="display: block; width: 379px; height: 256px;" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    {{-- Creacion de la grafica de analisis de tablas --}}
                    {{-- <div class="grid grid-cols-2 pt-4 space-y-8 lg:gap-8 lg:space-y-0 lg:grid-cols-4">
                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Tables</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="tables"  class="w-100 h-100"></canvas>
                            </div>
                        </div>
                        <div class="col-span-2 bg-white rounded-md dark:bg-gray-900">
                            <div class="text-center p-4 border-b dark:border-primary">
                                <h4 class="text-lg font-semibold text-white dark:text-light">Tables Today</h4>
                            </div>
                            <div class="flex justify-center items-center p-4 h-72">
                                <canvas id="tables-today"  class="w-100 h-100"></canvas>
                            </div>
                        </div>
                    </div> --}}
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
        const total = document.getElementById('total');
        const ctx2 = document.getElementById('total-method');
        // const ctx3 = document.getElementById('today');
        // const ctx4 = document.getElementById('today-method');
        // const ctx5 = document.getElementById('tables');
        // const ctx6 = document.getElementById('tables-today');
        // const ctx7 = document.getElementById('week');
        // const ctx8 = document.getElementById('week-method');
        // const ctx9 = document.getElementById('month');
        // const ctx10 = document.getElementById('month-method');
        // const ctx11 = document.getElementById('year');
        // const ctx12 = document.getElementById('year-method');

        let tag = new Set();
        var request = [];
        var error = [];

        @foreach ($historical['request']['total']['details'] as $request)
            request.push({"year":"{{$request['year']}}", "total":"{{$request['total']}}"});
        @endforeach

        @foreach ($historical['errors']['total']['details'] as $error)
            error.push({"year":"{{$error['year']}}", "total":"{{$error['total']}}"});
        @endforeach

        // Obtenemos los años en cada arreglo
        request.forEach(item => tag.add(item.year));
        error.forEach(item => tag.add(item.year));

        // Convertimos el set a un array
        tag = Array.from(tag);

        // Agregamos el año y valor faltante al arreglo
        tag.forEach(year => {
            if (!request.some(item => item.year === year)) {
                request.push({ year: year, total: 0 });
            }
        });

        tag.forEach(year => {
            if (!error.some(item => item.year === year)) {
                error.push({ year: year, total: 0 });
            }
        });

        // Ordenar los arreglos por año para mantenerlos organizados
        request.sort((a, b) => a.year - b.year);
        error.sort((a, b) => a.year - b.year);
        tag.sort();

        // Separar los totales de peticiones y errores
        let totalRequest = request.map(item => item.total);
        let totalError = error.map(item => item.total);

        new Chart(historicalTotal, {
            type: 'line',
            data: {
                labels: tag,
                datasets: [{
                    label: 'Request',
                    data: totalRequest,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    pointBackgroundColor: 'rgb(75, 192, 192)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(75, 192, 192)'
                }, {
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
        let request2 = [];
        let error2 = [];

        @foreach ($historical['request']['year']['details'] as $request)
            request2.push({"month":"{{$request['month']}}", "total":"{{$request['total']}}"});
        @endforeach

        @foreach ($historical['errors']['year']['details'] as $error)
            error2.push({"month":"{{$error['month']}}", "total":"{{$error['total']}}"});
        @endforeach

        // Obtenemos los meses en cada arreglo
        request2.forEach(item => tag2.add(item.month));
        error2.forEach(item => tag2.add(item.month));

        // Convertimos el set a un array
        tag2 = Array.from(tag2);

        // Agregamos el año y valor faltante al arreglo
        tag2.forEach(month => {
            if (!request2.some(item => item.month === month)) {
                request2.push({ month: month, total: 0 });
            }
        });

        tag2.forEach(month => {
            if (!error2.some(item => item.month === month)) {
                error2.push({ month: month, total: 0 });
            }
        });

        // Ordenar los arreglos por año para mantenerlos organizados
        request2.sort((a, b) => a.month - b.month);
        error2.sort((a, b) => a.month - b.month);
        tag2.sort();

        // Separar los totales de peticiones y errores
        let totalRequest2 = request2.map(item => item.total);
        let totalError2 = error2.map(item => item.total);

        new Chart(historicalYear, {
            type: 'radar',
            data: {
                labels: tag2,
                datasets: [{
                    label: 'Request',
                    data: totalRequest2,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    pointBackgroundColor: 'rgb(75, 192, 192)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(75, 192, 192)'
                }, {
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

        new Chart(total, {
            type: 'doughnut',
            data: {
                labels: ['Request', 'Errors'], // Etiquetas de datos
                datasets: [{
                    label: 'Total', // Etiqueta principal
                    data: [ // Datos
                        {{ $statistics['request']['total']['total'] }},
                        {{ $statistics['errors']['total']['total'] }}
                    ],
                    backgroundColor: [ // Color del grafico
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [ // Color del borde
                        'rgb(75, 192, 192)',
                        'rgb(255, 99, 132)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
            }
        });

        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['GET', 'POST', 'PUT', 'DELETE'],
                datasets: [{
                    label: 'Request',
                    data: [
                        {{ $statistics['request']['total']['method']['GET'] }},
                        {{ $statistics['request']['total']['method']['POST'] }},
                        {{ $statistics['request']['total']['method']['PUT'] }},
                        {{ $statistics['request']['total']['method']['DELETE'] }},
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgb(75, 192, 192)',
                        'rgb(75, 192, 192)',
                        'rgb(75, 192, 192)',
                        'rgb(75, 192, 192)',
                    ],
                    borderWidth: 3
                }, {
                    label: 'Error',
                    data: [
                        {{ $statistics['errors']['total']['method']['GET'] }},
                        {{ $statistics['errors']['total']['method']['POST'] }},
                        {{ $statistics['errors']['total']['method']['PUT'] }},
                        {{ $statistics['errors']['total']['method']['DELETE'] }},
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

        {{--new Chart(ctx3, {--}}
        {{--    type: 'doughnut',--}}
        {{--    data: {--}}
        {{--        labels: ['Request', 'Last Minute'], // Etiquetas de datos--}}
        {{--        datasets: [{--}}
        {{--            label: 'Total', // Etiqueta principal--}}
        {{--            data: [ // Datos--}}
        {{--                {{ $statistics['request']['today']['total'] }},--}}
        {{--                {{ $statistics['request']['today']['total'] }}--}}
        {{--            ],--}}
        {{--            backgroundColor: [ // Conlor del grafico--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [ // Color del borde--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx4, {--}}
        {{--    type: 'bar',--}}
        {{--    data: {--}}
        {{--        labels: ['GET', 'POST', 'PUT', 'DELETE'],--}}
        {{--        datasets: [{--}}
        {{--            label: 'Request',--}}
        {{--            data: [--}}
        {{--                {{ $statistics['request']['today']['method']['GET'] }},--}}
        {{--                {{ $statistics['request']['today']['method']['POST'] }},--}}
        {{--                {{ $statistics['request']['today']['method']['PUT'] }},--}}
        {{--                {{ $statistics['request']['today']['method']['DELETE'] }},--}}
        {{--            ],--}}
        {{--            backgroundColor: [--}}
        {{--                'rgba(153, 102, 255, 0.2)',--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(54, 162, 235, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [--}}
        {{--                'rgb(153, 102, 255)',--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(54, 162, 235)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        let labels = [];
        let count = [];
        let countToday = [];
        let method = [];

        // new Chart(ctx5, {
        //     type: 'line',
        //     data: {
        //         labels: labels, // Etiquetas de datos
        //         datasets: [{
        //             label: 'Total', // Etiqueta principal
        //             data: count,
        //             backgroundColor: [ // Conlor del grafico
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 99, 132, 0.2)',
        //             ],
        //             borderColor: [ // Color del borde
        //                 'rgb(153, 102, 255)',
        //                 'rgb(255, 99, 132)',
        //             ],
        //             borderWidth: 3
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         indexAxis: 'x',
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // new Chart(ctx6, {
        //     type: 'line',
        //     data: {
        //         labels: labels, // Etiquetas de datos
        //         datasets: [{
        //             label: 'Today', // Etiqueta principal
        //             data: countToday,
        //             backgroundColor: [ // Conlor del grafico
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 99, 132, 0.2)',
        //             ],
        //             borderColor: [ // Color del borde
        //                 'rgb(153, 102, 255)',
        //                 'rgb(255, 99, 132)',
        //             ],
        //             borderWidth: 3
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         indexAxis: 'x',
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         },
        //     }
        // });

        {{--new Chart(ctx7, {--}}
        {{--    type: 'doughnut',--}}
        {{--    data: {--}}
        {{--        labels: ['Request', 'Errors'], // Etiquetas de datos--}}
        {{--        datasets: [{--}}
        {{--            label: 'Total', // Etiqueta principal--}}
        {{--            data: [ // Datos--}}
        {{--                {{ $statistics['request']['week']['total'] }},--}}
        {{--                {{ $statistics['errors']['week']['total'] }}--}}
        {{--            ],--}}
        {{--            backgroundColor: [ // Conlor del grafico--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [ // Color del borde--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx8, {--}}
        {{--    type: 'bar',--}}
        {{--    data: {--}}
        {{--        labels: ['GET', 'POST', 'PUT', 'DELETE'],--}}
        {{--        datasets: [{--}}
        {{--            label: 'Request',--}}
        {{--            data: [--}}
        {{--                {{ $statistics['request']['week']['method']['GET'] }},--}}
        {{--                {{ $statistics['request']['week']['method']['POST'] }},--}}
        {{--                {{ $statistics['request']['week']['method']['PUT'] }},--}}
        {{--                {{ $statistics['request']['week']['method']['DELETE'] }},--}}
        {{--            ],--}}
        {{--            backgroundColor: [--}}
        {{--                'rgba(153, 102, 255, 0.2)',--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(54, 162, 235, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [--}}
        {{--                'rgb(153, 102, 255)',--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(54, 162, 235)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx9, {--}}
        {{--    type: 'doughnut',--}}
        {{--    data: {--}}
        {{--        labels: ['Request', 'Errors'], // Etiquetas de datos--}}
        {{--        datasets: [{--}}
        {{--            label: 'Total', // Etiqueta principal--}}
        {{--            data: [ // Datos--}}
        {{--                {{ $statistics['request']['month']['total'] }},--}}
        {{--                {{ $statistics['errors']['month']['total'] }}--}}
        {{--            ],--}}
        {{--            backgroundColor: [ // Conlor del grafico--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [ // Color del borde--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx10, {--}}
        {{--    type: 'bar',--}}
        {{--    data: {--}}
        {{--        labels: ['GET', 'POST', 'PUT', 'DELETE'],--}}
        {{--        datasets: [{--}}
        {{--            label: 'Request',--}}
        {{--            data: [--}}
        {{--                {{ $statistics['request']['month']['method']['GET'] }},--}}
        {{--                {{ $statistics['request']['month']['method']['POST'] }},--}}
        {{--                {{ $statistics['request']['month']['method']['PUT'] }},--}}
        {{--                {{ $statistics['request']['month']['method']['DELETE'] }},--}}
        {{--            ],--}}
        {{--            backgroundColor: [--}}
        {{--                'rgba(153, 102, 255, 0.2)',--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(54, 162, 235, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [--}}
        {{--                'rgb(153, 102, 255)',--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(54, 162, 235)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx11, {--}}
        {{--    type: 'doughnut',--}}
        {{--    data: {--}}
        {{--        labels: ['Request', 'Errors'], // Etiquetas de datos--}}
        {{--        datasets: [{--}}
        {{--            label: 'Total', // Etiqueta principal--}}
        {{--            data: [ // Datos--}}
        {{--                {{ $statistics['request']['year']['total'] }},--}}
        {{--                {{ $statistics['errors']['year']['total'] }}--}}
        {{--            ],--}}
        {{--            backgroundColor: [ // Conlor del grafico--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [ // Color del borde--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

        {{--new Chart(ctx12, {--}}
        {{--    type: 'bar',--}}
        {{--    data: {--}}
        {{--        labels: ['GET', 'POST', 'PUT', 'DELETE'],--}}
        {{--        datasets: [{--}}
        {{--            label: 'Request',--}}
        {{--            data: [--}}
        {{--                {{ $statistics['request']['year']['method']['GET'] }},--}}
        {{--                {{ $statistics['request']['year']['method']['POST'] }},--}}
        {{--                {{ $statistics['request']['year']['method']['PUT'] }},--}}
        {{--                {{ $statistics['request']['year']['method']['DELETE'] }},--}}
        {{--            ],--}}
        {{--            backgroundColor: [--}}
        {{--                'rgba(153, 102, 255, 0.2)',--}}
        {{--                'rgba(75, 192, 192, 0.2)',--}}
        {{--                'rgba(54, 162, 235, 0.2)',--}}
        {{--                'rgba(255, 99, 132, 0.2)',--}}
        {{--            ],--}}
        {{--            borderColor: [--}}
        {{--                'rgb(153, 102, 255)',--}}
        {{--                'rgb(75, 192, 192)',--}}
        {{--                'rgb(54, 162, 235)',--}}
        {{--                'rgb(255, 99, 132)',--}}
        {{--            ],--}}
        {{--            borderWidth: 3--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    options: {--}}
        {{--        responsive: true,--}}
        {{--    }--}}
        {{--});--}}

    </script>
@endsection