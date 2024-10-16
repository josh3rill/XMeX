<div class="container">
    <h1 class="mt-5">Real-Time Stock Report</h1>
    <table class="table table-bordered mt-3">
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
</div>
