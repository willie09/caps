<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Total Sales</h3>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">P{{ number_format($totalSales, 2) }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Total Expenses</h3>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">P{{ number_format($totalExpenses, 2) }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Net Worth</h3>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">P{{ number_format($netWorth, 2) }}</p>
                    </div>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Monthly Income and Expenses</h3>
                    <canvas id="incomeExpensesChart" width="400" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('incomeExpensesChart').getContext('2d');
        const incomeExpensesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartMonths->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))),
                datasets: [
                    {
                        label: 'Income',
                        data: @json($chartIncomeData),
                        borderColor: 'rgba(34, 197, 94, 1)', // green
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        fill: true,
                        tension: 0.3,
                    },
                    {
                        label: 'Expenses',
                        data: @json($chartExpensesData),
                        borderColor: 'rgba(239, 68, 68, 1)', // red
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        fill: true,
                        tension: 0.3,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'P' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
