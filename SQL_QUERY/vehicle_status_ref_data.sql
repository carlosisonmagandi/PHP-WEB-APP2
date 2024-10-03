CREATE TABLE vehicle_status_ref_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_title VARCHAR(255),
    status_description VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(255),
    updated_by VARCHAR(255)
);

SELECT * from vehicle_status_ref_data;

INSERT INTO vehicle_status_ref_data (status_title,status_description) VALUES ('Test','Test desc');