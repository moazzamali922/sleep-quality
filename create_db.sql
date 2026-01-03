USE sleep_quality;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    sleep_time TIME,
    wake_time TIME,
    stress VARCHAR(20),
    noise VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
