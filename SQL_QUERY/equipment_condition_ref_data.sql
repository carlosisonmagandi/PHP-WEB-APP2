CREATE TABLE equipment_condition_ref_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    condition_title VARCHAR(255),
    condition_description VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
SELECT * FROM equipment_condition_ref_data;

INSERT INTO equipment_condition_ref_data (condition_title,condition_description) VALUES ('Confiscated','Currently confiscated by PENRO');