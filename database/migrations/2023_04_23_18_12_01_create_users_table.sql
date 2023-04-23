CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name varchar(25) NOT NULL,
    last_name varchar(25) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password varchar(100) NOT NULL,
    birth_date DATE NOT NULL,
    image varchar(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
