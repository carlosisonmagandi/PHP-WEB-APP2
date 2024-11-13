CREATE TABLE equipment_type_ref_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_title VARCHAR(255),
    type_description VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * from equipment_type_ref_data;

INSERT INTO equipment_type_ref_data (type_title,type_description) VALUES ('Test','Test desc');