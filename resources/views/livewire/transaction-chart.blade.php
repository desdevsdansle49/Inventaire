<div class="bg-white rounded p-5 m-4">
    <main role="main" class="container">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <label for="itemSelect">Choisir un item:</label>
                        <select id="itemSelect">
                            <option wire:model="itemName" value="">Tous les items</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 ">
                        <h3 class="ps-3 d-flex justify-content-center">Departement</h3>
                        <canvas id="departmentChart" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h3 class="ps-3 d-flex justify-content-center">Unit</h3>
                        <canvas id="unitChart" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h3 class="ms-3 d-flex justify-content-center">Employee</h3>
                        <canvas id="employeeChart" width="400" height="400"></canvas>
                    </div>
                </div>
                <p>{{ $transactions }}</p>
            </div>

            <script>
                const departments = @json($departments);
                const units = @json($units);
                const employees = @json($employees);

                // Couleurs plus professionnelles
                const professionalColors = [
                    "#708090", "#778899", "#2F4F4F", "#696969", "#808080", "#A9A9A9", "#C0C0C0"
                ];

                function getProfessionalColor(index) {
                    return professionalColors[index % professionalColors.length];
                }

                function createChartData(data, selectedItem) {
                    const labels = data.map(d => d.name);
                    const values = data.map(d => selectedItem ? d.items.find(item => item.itemName === selectedItem)?.itemNumber ||
                        0 : d.total);
                    const backgroundColors = data.map((_, index) => getProfessionalColor(index));

                    return {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: backgroundColors,
                        }]
                    };
                }

                const chartOptions = {
                    animation: {
                        duration: 0
                    }
                };

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
                    options: chartOptions
                });

                const unitCtx = document.getElementById('unitChart').getContext('2d');
                const unitPieChart = new Chart(unitCtx, {
                    type: 'pie',
                    data: createChartData(units),
                    options: chartOptions
                });

                const employeeCtx = document.getElementById('employeeChart').getContext('2d');
                const employeePieChart = new Chart(employeeCtx, {
                    type: 'pie',
                    data: createChartData(employees),
                    options: chartOptions
                });

                const itemSelect = document.getElementById('itemSelect');
                itemSelect.addEventListener('change', function() {
                    updateCharts(itemSelect.value);
                });

                function separateData(inputArray) {
                    var dates = [];
                    var counts = [];

                    for (var i = 0; i < inputArray.length; i++) {
                        dates.push(inputArray[i].date);
                        counts.push(inputArray[i].count);
                    }

                    return {
                        dates: dates,
                        counts: counts
                    };
                }
            </script>

        </div>
    </main>
</div>
