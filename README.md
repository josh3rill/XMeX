# XMeX
 Employment accessment

## Project Setup

This project was initialized with Docker. Follow the steps below to set up and run the project.

### Prerequisites

- Docker
- Docker Compose

### Steps to Set Up the Project

1. **Clone the Repository**

   ```sh
   git clone <https://github.com/josh3rill/XMeX.git>
   cd <XMeX>
   ```

2. **Build and Run Docker Containers**

   Navigate to the project root and run the following command:

   ```sh
   docker-compose up --build
   ```

3. **Access the Docker Container**

   After a successful build, access the Docker container named `php_XMex`:

   ```sh
   docker exec -it php_XMex bash
   ```

4. **Install Composer Dependencies**

   Inside the Docker container, run:

   ```sh
   composer install
   ```

5. **Run Migrations and Seeders**

   Run the following commands to set up the database:

   ```sh
   php artisan migrate --seed
   php artisan db:seed --class=StockSymbolsSeeder
   ```

### Handling Scheduler Issues

In case the scheduler running in Docker does not update the database due to key restrictions, manually run the following commands in the terminal:

```sh
php artisan stocks:fetch
php artisan cache:update
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

### Summary

- **Clone the repository** and navigate to the project directory.
- **Build and run Docker containers** using `docker-compose up --build`.
- **Access the Docker container** and run `composer install`.
- **Run migrations and seeders** using `php artisan migrate --seed` and `php artisan db:seed --class=StockSymbolsSeeder`.
- **Manually run commands** if the scheduler does not update the database: `php artisan stocks:fetch` and `php artisan cache:update`.
- **Access the API endpoint** at `https://localhost:8082/api/v1/stock`.
- **View the GUI** at `https://localhost:8082`.

By following these steps, you can set up and run the project successfully.
