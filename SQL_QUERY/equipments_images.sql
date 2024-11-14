CREATE TABLE equipments_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipment_id) REFERENCES equipments(id) ON DELETE CASCADE
);

Select * from equipments_images;
delete from equipments_images where id in(1,2);