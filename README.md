# MyConsultHours

MyConsultHours is a web-based tool that allows consultants to log their working hours, track analytics, and manage consultancy tasks efficiently.

## Features

- Log consultancy hours
- View logged hours in a table format
- Track daily, weekly, and monthly analytics
- User authentication

## Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, MySQL
- **Deployment**: Netlify (Frontend), PHP Hosting (Backend)

---

## Installation Guide

### Prerequisites

Ensure you have the following installed:

- PHP (>=7.4)
- MySQL Database
- Web server (Apache, Nginx, or XAMPP for local testing)

### 1️⃣ Clone the Repository

```sh
git clone https://github.com/Abdull-Razaq/myconsult-user

```

### 2️⃣ Set Up the Backend (PHP & MySQL)

1. **Import the Database**

   - Create a database in MySQL: `CREATE DATABASE myconsulthours;`
   - Import the provided SQL file: `myconsulthours-1.sql`

2. **Configure Database Connection**

   - Open `config.php`
   - Update database credentials:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "myconsulthours-1";
     ```

3. **Host the Backend**

   - Place the PHP files (`get_user.php`, `fetch_hours.php`, `submit_hours.php`, etc.) in your web server's root folder (e.g., `htdocs/myconsulthours/` for XAMPP).

### 3️⃣ Set Up the Frontend

1. **Deploy Locally**

   - Open `index.html` in a browser.
   - Update API endpoints in `script.js` to match your backend host:
     ```js
     fetch('https://yourbackend.com/fetch_hours.php')
     ```

2. **Deploy to Netlify**

   - Place only the frontend files (`index.html`, `css/`, `script.js`) in a new folder.
   - Push it to GitHub.
   - Deploy via [Netlify](https://www.netlify.com/):
     - Drag & drop the frontend folder in Netlify.
     - Update the backend URLs in `script.js` to match the live backend URL.

---

## Usage Guide

1. **Log In**

   - Open the deployed frontend.
   - Enter credentials and log in.

2. **Log Consultancy Hours**

   - Click "Log Hours" and submit hours.
   - View recorded hours in the table.

3. **View Analytics**

   - The homepage displays hours logged today, this week, and this month.

---

## Troubleshooting

### ❌ Error: `This myconsulthours-user.netlify.app page can’t be found`

✅ Ensure:

- Your **backend is deployed correctly** on a PHP-supported host.
- API endpoints in `script.js` point to the correct backend URL.
- `fetch_hours.php`, `get_analytics.php`, and `get_user.php` are accessible.

### ❌ Error: `Network response was not ok`

✅ Ensure:

- The database is correctly set up.
- PHP files have correct permissions (`chmod 755`).
- CORS is enabled in PHP:
  ```php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST");
  header("Access-Control-Allow-Headers: Content-Type");
  ```

---

## License

This project is licensed under the MIT License.

---


