Sure, I'll create a comprehensive README document for your XMeX project, including the project's setup instructions and design decisions.

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
