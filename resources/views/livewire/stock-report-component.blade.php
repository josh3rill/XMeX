<table>
    <thead>
        <tr>
            <th>Symbol</th>
            <th>Price</th>
            <th>Previous Close</th>
            <th>Percentage Change</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $stock)
            <tr>
                <td>{{ $stock['symbol'] }}</td>
                <td>{{ $stock['price'] }}</td>
                <td>{{ $stock['previous_close'] }}</td>
                <td>{{ number_format($stock['percentage_change'], 2) }}%</td>
                <td>{{ $stock['timestamp'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.addEventListener('livewire:load', function () {
        setInterval(function () {
            Livewire.emit('refreshStockData');
        }, 5000); // 20 seconds
    });
</script>










































<!-- AAPL -->