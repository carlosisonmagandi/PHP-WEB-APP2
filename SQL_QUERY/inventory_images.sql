CREATE TABLE inventory_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inventory_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    activity_date VARCHAR(255),
    date_created VARCHAR(255),
    FOREIGN KEY (inventory_id) REFERENCES inventory(id) ON DELETE CASCADE
);

select * from inventory_images;
