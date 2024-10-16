
---

# XMeX

Employment assessment project for managing and displaying stock data.

## Project Setup

This project is initialized with Docker. Follow the steps below to set up and run the project.

### Prerequisites

- Docker
- Docker Compose

### Steps to Set Up the Project

1. **Clone the Repository**

   ```sh
   git clone https://github.com/josh3rill/XMeX.git
   cd XMeX
   ```

2. **Copy Environment Configuration**

   Copy the 

.env.example

 file to 

.env

:

   ```sh
   cp .env.example .env
   ```

3. **Build and Run Docker Containers**

   Navigate to the project root and run the following command:

   ```sh
   docker-compose up --build -d
   ```

4. **Access the Docker Container**

   After a successful build, access the Docker container named `php_XMex`:

   ```sh
   docker exec -it php_XMex /bin/sh
   ```

5. **Run Startup Script**

   Run the following command to configure the Laravel environment and set up the application:

   ```sh
   php artisan app:startup
   ```

### API Endpoint

To list the stocks, use the following endpoint:

```
https://localhost:8082/api/v1/stock
```

### GUI Access

For users to view the stock data in a GUI, the project uses Livewire to update the view regularly. Visit the following URL:

```
https://localhost:8082
```

## Design Decisions

### 1. Service Container and Dependency Injection

**Reason**: To promote loose coupling and make the code more testable.

**Implementation**: 
- Services like `AlphaVantageService` are registered in the service container and injected into commands and other services as needed.

### 2. Command Pattern

**Reason**: To encapsulate all information needed to perform an action or trigger an event.

**Implementation**: 
- Artisan commands like `FetchStockPricesCommand` encapsulate CLI logic for fetching stock prices.

### 3. Repository Pattern

**Reason**: To abstract the data layer, making the application more flexible and easier to maintain.

**Implementation**: 
- Repositories handle data access, though not explicitly shown in the provided code, it's a common practice in Laravel applications.

### 4. Job Queue

**Reason**: To handle time-consuming tasks asynchronously, improving the application's performance and responsiveness.

**Implementation**: 
- Jobs like `UpdateCacheFromDatabase` handle asynchronous tasks such as updating the cache.

### 5. Singleton Pattern

**Reason**: To ensure that a class has only one instance and provide a global point of access to it.

**Implementation**: 
- Services like `AlphaVantageService` are registered as singletons in the service provider.

### 6. Separation of Concerns

**Reason**: To ensure that each class and method has a single responsibility, making the code easier to maintain and test.

**Implementation**: 
- Controllers are thin and delegate business logic to services.
- Services encapsulate business logic.
- Repositories handle data access.
- Commands encapsulate CLI logic.
- Jobs handle asynchronous tasks.

### 7. Configuration Management

**Reason**: To make the application configurable and adaptable to different environments.

**Implementation**: 
- Configuration values are stored in environment variables and accessed via the 

config

 helper.

### 8. Error Handling and Logging

**Reason**: To ensure that errors are properly handled and logged for debugging and monitoring purposes.

**Implementation**: 
- Try-catch blocks are used to handle exceptions.
- Errors and warnings are logged using Laravel's logging facilities.



## Architecture

### Overview

The XMeX project follows a layered architecture with clear separation of concerns. The main layers are:

1. **Controllers**: Handle HTTP requests and responses.
2. **Services**: Encapsulate business logic.
3. **Repositories**: Handle data access and interactions with the database.
4. **Jobs**: Manage asynchronous tasks.
5. **Models**: Represent the database entities.

### Directory Structure

```
/app
    /Console
    /Exceptions
    /Http
        /Controllers
        /Middleware
    /Jobs
    /Models
    /Providers
    /Repositories
    /Services
/bootstrap
/config
/database
    /factories
    /migrations
    /seeders
/public
/resources
    /views
/routes
/storage
/tests
/vendor
```



### Environment Variables

The `.env` file contains environment-specific configurations. Here are some key variables:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:d9fZcYHjegcEXFWYyy7y+CDyctHhNgKnuwfyMBUQxRs=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12
LOG_CHANNEL=stack
LOG_LEVEL=debug
QUEUE_CONNECTION=redis
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=micro1
DB_USERNAME=root
DB_PASSWORD=root
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_DRIVER=redis
CACHE_STORE=database
REDIS_CLIENT=phpredis
REDIS_HOST=redis_XMex
REDIS_PORT=6379
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
ALPHA_VANTAGE_API_KEY=HN82UVS50X8HEWJB
```

### Pint Configuration

Laravel Pint is used to ensure consistent coding standards and formatting. The `pint.json` file contains the configuration:

```json
{
    "preset": "laravel",
    "rules": {
        "array_syntax": {
            "syntax": "short"
        },
        "binary_operator_spaces": {
            "default": "single_space"
        },
        "blank_line_after_namespace": true,
        "blank_line_after_opening_tag": true,
        "blank_line_before_statement": {
            "statements": ["return"]
        },
        "braces": {
            "allow_single_line_closure": true
        },
        "cast_spaces": {
            "space": "single"
        },
        "class_attributes_separation": {
            "elements": {
                "method": "one"
            }
        }
    }
}
```

### Testing

The project includes unit, feature, and integration tests to ensure code reliability. Tests are located in the `tests` directory.

**Example Test**:

```php
<?php

namespace Tests\Feature;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    public function testUserFlow()
    {
        // Create stock data
        $stock = Stock::factory()->create(['symbol' => 'AAPL', 'close' => 150, 'previous_close' => 145, 'timestamp' => now()]);

        // Test API endpoint
        $response = $this->getJson('/api/v1/stocks/AAPL');
        $response->assertStatus(200);
        $response->assertJson([
            'symbol' => 'AAPL',
            'price' => 150,
        ]);

        // Test frontend view
        $response = $this->get('/stock-report');
        $response->assertStatus(200);
        $response->assertSee('AAPL');
        $response->assertSee('150');
    }
}
```
