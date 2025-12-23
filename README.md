# PhotoVault 📸

PhotoVault is a simple, secure personal photo gallery application built with **PHP** and **Tailwind CSS**. It allows users to create accounts, upload photos, and manage their personal gallery in a private space.

## 🚀 Features

- **User Authentication**: Secure Login & Registration system using `password_hash`.
- **Personal Gallery**: Each user sees only their own uploaded photos.
- **Image Upload**: Drag-and-drop or click-to-upload interface.
- **Management**: Delete and download photos easily.
- **Modern UI**: Clean, responsive design using Tailwind CSS.

## 🛠️ Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL or MariaDB
- A web server (Apache, Nginx, or PHP's built-in server)

### 1. Database Setup
Create a new database (e.g., `photovault`) and run the following SQL commands to create the necessary tables:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 2. Configuration
Create a `db.php` file in the root directory with your database credentials. This file is ignored by Git for security.

**`db.php` example:**
```php
<?php
$host = 'localhost';
$dbname = 'photovault';
$user = 'root';
$pass = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

### 3. Permissions
Ensure the `uploads/` directory exists and has write permissions:

```bash
mkdir -p uploads
chmod 777 uploads
```

## 🏃‍♂️ Running the Project

You can use PHP's built-in server for quick testing:

```bash
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser.

## 🤝 Contributing
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📄 License
This project is open-source and free to use.
