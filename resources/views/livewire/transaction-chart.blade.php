<div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <label for="itemSelect">Select an item:</label>
                <select id="itemSelect">
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
    </div>

    <script>
        const departments = @json($departments);
        const units = @json($units);
        const employees = @json($employees);

        function createChartData(data, selectedItem) {
            const labels = data.map(d => d.name);
            const values = data.map(d => selectedItem ? d.items.find(item => item.itemName === selectedItem)?.itemNumber ||
                0 : d.total);
            const backgroundColors = data.map(() => '#' + Math.floor(Math.random() * 16777215).toString(16));

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

        const itemSelect = document.getElementById('itemSelect');
        itemSelect.addEventListener('change', function() {
            updateCharts(itemSelect.value);
        });
    </script>
</div>
