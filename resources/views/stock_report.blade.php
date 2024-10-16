<!-- 
R 
 -->
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XM Excercise</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
  @livewireStyles
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>Symbols</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="{{ asset('images/search.png') }}" alt="">
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="{{ asset('images/pdf.png') }}" alt=""></label>
                    <label for="export-file" id="toJSON">JSON <img src="{{ asset('images/json.png') }}" alt=""></label>
                    <label for="export-file" id="toCSV">CSV <img src="{{ asset('images/csv.png') }}" alt=""></label>
                    <label for="export-file" id="toEXCEL">EXCEL <img src="{{ asset('images/excel.png') }}" alt=""></label>

                   
                </div>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Symbol <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Price <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Previous Close <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Percentage Change <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Timestamp<span class="icon-arrow">&UpArrow;</span></th>
                        
                    </tr>
                </thead>
                <tbody>
                       
                   
                       @foreach ($report as $stock)
                    <tr>
                        <td>{{ $stock['symbol'] }}</td>
                        <td> {{ $stock['price'] }} </td>
                        <td>{{ $stock['previous_close'] }}</td>
                        <td>{{ number_format($stock['percentage_change'], 2) }}%</td>
                        <td>{{ $stock['timestamp'] }}</td>
                        <td> <strong>EXPORT</strong> </td>
                    </tr>
                     @endforeach
                 
                </tbody>
            </table>
        </section>
    </main>
    <script src="{{ asset('js/script.js') }}"></script>
    @livewireScripts
    <script>
        // Set an interval to refresh the table every 10 seconds
        setInterval(function() {
            Livewire.emit('refreshTable');
        }, 10000); // 10 seconds
    </script>
</body>

</html>




                        
                   
