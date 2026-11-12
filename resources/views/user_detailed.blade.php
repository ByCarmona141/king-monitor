@extends('king-monitor::layouts.app')

@section('title')
    {{ config('app.name', 'Monitor') }} - User - Detailed
@endsection

@section('header')
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ __('Monitor') }} - User - Detailed
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

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 sm:mt-0 md:mt-0 xl:mt-0">
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

                            <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/4 xl:mt-0">
                                <div class="flex items-center px-5 py-6 dark:bg-gray-900 rounded-md shadow-sm">
                                    <div class="p-3 bg-gradient-to-tl from-gray-900 to-gray-700 shadow-soft-2xl rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#FFFFFF">
                                            <path d="m438-240 226-226-58-58-169 169-84-84-57 57 142 142ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                                        </svg>
                                    </div>

                                    <div class="mx-5">
                                        <h4 class="text-2xl font-semibold text-white">
                                            {{$statisticsExceeded['request']['total']['total']}}
                                        </h4>
                                        <div class="text-gray-500">Total Exceeded Request</div>
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
                                        <h4 class="text-2xl font-semibold text-white">{{$statisticsExceeded['errors']['total']['total']}}</h4>
                                        <div class="text-gray-500">Total Exceeded Errors</div>
                                    </div>
                                </div>
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