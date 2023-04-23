CREATE TABLE user_access_token (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    access_token VARCHAR(1000) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
)
