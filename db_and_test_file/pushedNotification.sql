CREATE TABLE pushedNotification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date_created DATE,
    time_created TIME,
    status VARCHAR(20) NOT NULL,
    landing_page VARCHAR(255)
);

SELECT * from pushedNotification;

ALTER TABLE pushedNotification
ADD COLUMN user_id INT;

ALTER TABLE pushedNotification
CHANGE COLUMN user_id user_name VARCHAR(255);


