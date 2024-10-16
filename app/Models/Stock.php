<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'stocks';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'symbol',    // Stock symbol (e.g., MSFT, GOOGL, AAPL)
        'timestamp', // Timestamp of the data point
        'open',      // Open price
        'high',      // High price
        'low',       // Low price
        'close',     // Close price
        'volume',    // Trading volume
    ];

    // Optionally, you can define any casts for your attributes
    protected $casts = [
        'timestamp' => 'datetime', // Cast timestamp to Carbon instance
        'open' => 'decimal:6',     // Cast open price to decimal with 6 decimal points
        'high' => 'decimal:6',     // Cast high price to decimal with 6 decimal points
        'low' => 'decimal:6',      // Cast low price to decimal with 6 decimal points
        'close' => 'decimal:6',    // Cast close price to decimal with 6 decimal points
        'volume' => 'integer',      // Cast volume to integer
    ];
}
