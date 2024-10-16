<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XM Exercise</title>
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
            @livewire('stock-report-component')
        </section>
    </main>
    <script src="{{ asset('js/script.js') }}"></script>
    @livewireScripts
    <script>
    document.addEventListener('livewire:load', function () {
        setInterval(function () {
            Livewire.emit('refreshStockData');
        }, 5000); // 20 seconds
    });
</script>
</body>

</html>