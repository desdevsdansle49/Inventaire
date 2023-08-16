<div>
    <select wire:model="selectedItem">
        <option value="">Choisir un article</option>
        @foreach ($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
    <div class="d-flex justify-content-around" style="height: 100vh; align-items: center;">
        <div class="flex-fill d-flex justify-content-center">
            <canvas id="transactionChart" style="width: 80%; height: 80%;"></canvas>
        </div>
        <div class="flex-fill d-flex justify-content-center">
            <canvas style="width: 80%; height: 80%;"></canvas>
        </div>
        <div class="flex-fill d-flex justify-content-center">
            <canvas style="width: 80%; height: 80%;"></canvas>
        </div>
    </div>



    <script>
        var chart;

        window.addEventListener('contentChanged', event => {
            if (chart) chart.destroy(); // Destroy the existing chart
            var ctx = document.getElementById('transactionChart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $transactions->pluck('date') !!},
                    datasets: [{
                        label: 'Nombre de transactions',
                        data: {!! $transactions->pluck('count') !!},
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false
                    }]
                },
                options: {
                    animation: {
                        duration: 0 // Disable animation
                    }
                }
            });
        });

        // Trigger the event initially to draw the chart
        window.dispatchEvent(new Event('contentChanged'));
    </script>



</div>
