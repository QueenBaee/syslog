# ISP Network Monitoring System

A comprehensive Laravel-based web application for monitoring and managing ISP network infrastructure devices with downtime tracking and maintenance logging capabilities.

## Features

- **Device Management**: Create, edit, and manage network devices (Metro, Genset, NAP, Exchange, Active Devices)
- **Real-time Status Monitoring**: Track online/offline status of network infrastructure
- **Downtime Logging**: Record and manage maintenance activities and downtime incidents
- **Interactive Dashboard**: Visual overview of all device categories with status summaries
- **AJAX Modal Interface**: Modern, responsive UI with modal-based CRUD operations
- **PDF Reports**: Generate and download maintenance log reports (All time or current month)
- **Tabbed Navigation**: Clean category filtering with horizontal tab interface
- **Dynamic IP Management**: IP address field visibility based on device category

## Technology Stack

- **Backend**: Laravel 12.x, PHP 8.4
- **Frontend**: Bootstrap 5, Tabler Admin UI, SweetAlert2
- **Database**: MySQL
- **PDF Generation**: DomPDF
- **JavaScript**: Vanilla JS with AJAX

## Installation

### Prerequisites

- PHP 8.4 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM (optional, for asset compilation)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd syslog-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=syslog_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run database migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

## Usage

### Device Categories

- **Metro**: Metro Ethernet infrastructure
- **Genset**: Generator sets and power equipment
- **NAP**: Network Access Points
- **Exchange**: Network exchange equipment
- **Active Device**: Active network devices (routers, switches) - supports IP address assignment

### Key Operations

1. **Dashboard**: View summary statistics for all device categories
2. **Device Management**: Add/edit devices using modal interface
3. **Downtime Tracking**: Report and resolve maintenance incidents
4. **PDF Reports**: Generate maintenance logs for specific periods
5. **Status Monitoring**: Real-time online/offline status tracking

## Database Schema

### Devices Table
- `id`, `category`, `name`, `location`, `description`
- `ip_address` (nullable, only for active_device category)
- `current_status` (online/offline)
- `timestamps`, `soft_deletes`

### Downtime Logs Table
- `device_id`, `down_at`, `up_at`, `reason`, `effect`
- `duration_minutes` (auto-calculated)
- `timestamps`

## API Endpoints

- `GET /` - Dashboard
- `GET /devices` - Device index with tabbed filtering
- `POST /devices` - Create device (AJAX)
- `GET /devices/{id}/edit` - Get device data (AJAX)
- `PUT /devices/{id}` - Update device (AJAX)
- `GET /devices/{id}` - Device details page
- `GET /devices/{id}/print-logs` - Generate PDF report
- `POST /devices/{id}/logs` - Create downtime log
- `PUT /logs/{id}` - Resolve downtime log

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).