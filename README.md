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
   git clone https://github.com/josh3rill/XMeX.git
   cd XMeX
   ```

2. **Build and Run Docker Containers**

   Navigate to the project root and run the following command:
   copy .env.example to .env if not created during docker build


   ```sh

   cp .env.example  .env

   docker-compose up --build -d
   ```

3. **Access the Docker Container**

   After a successful build, access the Docker container named `php_XMex`:

   ```sh
   docker exec -it php_XMex /bin/sh
   ```

4.

5. **Run startup script**

   Run the following commands to configure env of laravel:

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



By following these steps, you can set up and run the project successfully.
