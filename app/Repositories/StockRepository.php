<?php
public function updateStock($symbol, $data)
{
    $this->validateSymbol($symbol);
    $this->validateStockData($data);

    $stock = Stock::firstOrNew(['symbol' => $symbol, 'timestamp' => $data['timestamp']]);
    $this->fillStockData($stock, $data);
    $stock->save();
}

private function fillStockData($stock, $data)
{
    $fields = ['open', 'high', 'low', 'close', 'volume', 'previous_close'];
    foreach ($fields as $field) {
        $stock->$field = $data[$field];
    }
}

private function validateSymbol($symbol)
{
    $validator = Validator::make(['symbol' => $symbol], [
        'symbol' => 'required|string|max:10',
    ]);

    if ($validator->fails()) {
        throw new ValidationException($validator);
    }
}

private function validateStockData($data)
{
    $validator = Validator::make($data, [
        'timestamp' => 'required|date',
        'open' => 'required|numeric',
        'high' => 'required|numeric',
        'low' => 'required|numeric',
        'close' => 'required|numeric',
        'volume' => 'required|integer',
        'previous_close' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        throw new ValidationException($validator);
    }
}