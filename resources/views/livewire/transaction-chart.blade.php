<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <label for="itemSelect">Select an item:</label>
                <select wire:model="itemName" id="itemSelect">
                    <option value="">All Items</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3>Department Transactions</h3>
                <canvas id="departmentChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h3>Unit Transactions</h3>
                <canvas id="unitChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h3>Employee Transactions</h3>
                <canvas id="employeeChart" width="400" height="400"></canvas>
            </div>
        </div>
        <canvas id="timeChart"></canvas>
        <p>{{ $transactions }}</p>

    </div>

    <script>
        const departments = @json($departments);
        const units = @json($units);
        const employees = @json($employees);

        function getRandomHSLColor() {
            const hue = Math.floor(Math.random() * 360);
            const saturation = 50 + Math.floor(Math.random() * 30); // Saturation entre 50 et 80
            const lightness = 40 + Math.floor(Math.random() * 30); // Luminosité entre 40 et 70
            return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
        }

        function generateUniqueColors(count) {
            const colors = new Set();
            while (colors.size < count) {
                colors.add(getRandomHSLColor());
            }
            return Array.from(colors);
        }

        function createChartData(data, selectedItem) {
            const labels = data.map(d => d.name);
            const values = data.map(d => selectedItem ? d.items.find(item => item.itemName === selectedItem)?.itemNumber ||
                0 : d.total);
            const backgroundColors = generateUniqueColors(data.length);

            return {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: backgroundColors,
                }]
            };
        }

        function updateCharts(selectedItem) {
            departmentPieChart.data = createChartData(departments, selectedItem);
            departmentPieChart.update();

            unitPieChart.data = createChartData(units, selectedItem);
            unitPieChart.update();

            employeePieChart.data = createChartData(employees, selectedItem);
            employeePieChart.update();

            // Update timeChart here
            timeChart.data.labels = {!! $transactions->pluck('date') !!};
            timeChart.data.datasets[0].data = {!! $transactions->pluck('count') !!};
            timeChart.update();
        }

        const departmentCtx = document.getElementById('departmentChart').getContext('2d');
        const departmentPieChart = new Chart(departmentCtx, {
            type: 'pie',
            data: createChartData(departments),
        });

        const unitCtx = document.getElementById('unitChart').getContext('2d');
        const unitPieChart = new Chart(unitCtx, {
            type: 'pie',
            data: createChartData(units),
        });

        const employeeCtx = document.getElementById('employeeChart').getContext('2d');
        const employeePieChart = new Chart(employeeCtx, {
            type: 'pie',
            data: createChartData(employees),
        });

        // function separateData(inputArray) {
        //     var dates = [];
        //     var counts = [];

        //     for (var i = 0; i < inputArray.length; i++) {
        //         dates.push(inputArray[i].date);
        //         counts.push(inputArray[i].count);
        //     }

        //     return {
        //         dates: dates,
        //         counts: counts
        //     };
        // }

        // const transactions = separateData(@json($transactions));

        // let ctx = document.getElementById('timeChart').getContext('2d');
        // let timeChart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: transactions.dates,
        //         datasets: [{
        //             label: 'Evolution de count',
        //             data: transactions.counts,
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // window.addEventListener('transactionsUpdated', event => {
        //     timeChart.data.pop();
        //     timeChart.data.push(transactions.counts);
        //     timeChart.update();
        // })
    </script>


</div>
