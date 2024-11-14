CREATE TABLE logs_type_ref_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_title VARCHAR(255),
    type_description VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    create_by VARCHAR(255),
    update_by VARCHAR(255)
);
SELECT * FROM logs_type_ref_data;

INSERT INTO logs_type_ref_data (type_title,type_description) VALUES ('Coals','Sample coals Description');