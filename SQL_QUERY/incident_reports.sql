CREATE TABLE incident_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
	report_number VARCHAR(255),
	state VARCHAR(225),
    assigned_by VARCHAR(225),
    assigned_to VARCHAR(225),
    isAccepted VARCHAR(225),
    date_assigned VARCHAR(225),
    date_reported VARCHAR(225),
    reported_by VARCHAR(225),
    created_by VARCHAR(255),
    updated_by VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    location varchar(225),
    coordinate_lat varchar(225),
    coordinate_lng varchar(225)
);

SELECT * FROM incident_reports;