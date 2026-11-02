
CREATE DATABASE IF NOT EXISTS user_management_db;

USE user_management_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('ADMIN', 'OPERATOR') NOT NULL,
    status ENUM('ACTIVE', 'INACTIVE') NOT NULL DEFAULT 'ACTIVE',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

-- Sample Admin:
-- Email: admin@example.com
-- Password: Admin@123

INSERT INTO users (name, email, password, role, status)
VALUES
('Administrator', 'admin@example.com', '$2y$10$LWwQ/u4wE9cTOQUQLyCaruYt9ukfgjBRQztQ7k8Jja04XEJf9ZBL.', 'ADMIN', 'ACTIVE'),
('Alex Operator', 'alex123@gmail.com', '$2y$10$Cely6RqSCHK8VdAqDVL6au9boGqJV2bv4Nj4ZIOPJ.ac3nAI8zYfC', 'OPERATOR', 'ACTIVE')
('Smith','smith123@gmail.com','$2y$10$YSPx4VAYxDvY4jiwTYYpUu8M5ZTGt8GEJOXNBTFomG99o3Mu0QJ1i','OPERATOR','ACTIVE'),
('Priya','priya123@gmail.com','$2y$10$y5qoNU6SX8cSiJK2DNuJEeObHjooHcd.YQhHYI2/3ipPvZ1o.rC8m','OPERATOR','ACTIVE'),
('Amit','amit321@gmail.com','$2y$10$KrNKMWIbvhNHPNNrKm3qZe/2beggTeBK3mKYu/zJVab9d8HPkfe42','OPERATOR','INACTIVE'),
('Sneha','sneha441@gmail.com','$2y$10$7zzw3LO7ZHDHJM7GESWRAu7PaGrCPUSrvY8NYJghaeJ.RW.q62Mbm','OPERATOR','INACTIVE'),
('Vikas','vikas123@gmail.com','$2y$10$4ji5kCLWDrQeJAFGz1IUfeRxDCOAt2JWo69pxLXBJ5R/gq5TYsXYa','OPERATOR','ACTIVE')


ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    password = VALUES(password),
    role = VALUES(role),
    status = VALUES(status);
