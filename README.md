# Booking System

This project is a booking system that allows students to reserve classes.

## Requirements

Ensure you have the following versions installed:

- **Composer**: Latest stable version
- **Symfony CLI**: Latest stable version
- **PHP**: Latest stable version with required extensions
- **MySQL Server**: Latest stable version
- **cURL**: Latest stable version

## Installation

Follow these steps to set up the project:

1. **Install MySQL Server**:
   - On Ubuntu: 
     ```bash
     sudo apt-get update
     sudo apt-get install mysql-server
     ```

2. **Install PHP and required extensions**:
   - On Ubuntu:
     ```bash
     sudo apt-get install php php-cli php-mbstring php-xml php-curl php-mysql php-zip
     ```

3. **Install cURL**:
   - On Ubuntu:
     ```bash
     sudo apt-get install curl
     ```

4. **Install Composer**:
   - Run the following commands:
     ```bash
     curl -sS https://getcomposer.org/installer | php
     sudo mv composer.phar /usr/local/bin/composer
     ```

5. **Install Symfony CLI**:
   - Run the following commands:
     ```bash
     curl -sS https://get.symfony.com/cli/installer | bash
     sudo mv ~/.symfony*/bin/symfony /usr/local/bin/symfony
     ```

6. **Clone the project repository**:
   ```bash
   git clone https://github.com/rjuanpablo/booking.git
   cd booking

7. **Install project dependencies**:
   ```bash
   composer install

8. **Database Setup**:

   - **Create the database and user**:
     ```bash
     sudo mysql -u root -p
     ```

     In the MySQL shell:
     ```sql
     CREATE DATABASE booking;
     CREATE USER 'suser'@'localhost' IDENTIFIED BY 'spass';
     GRANT ALL PRIVILEGES ON booking.* TO 'suser'@'localhost';
     FLUSH PRIVILEGES;
     ```

   - **Import the database structure**:
     ```bash
     sudo mysql -u root -p booking < booking_structure.sql
     ```

## Usage

To start the server, run:
```bash
symfony serve
```

You can now access the application in your web browser at `http://127.0.0.1:8000`.

## API Documentation

For detailed information about the API endpoints, check the [API Endpoints Documentation](ENDPOINTS.md).
