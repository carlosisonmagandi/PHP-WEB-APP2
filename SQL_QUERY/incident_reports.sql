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
DELETE FROM incident_reports WHERE id NOT IN (1);
ALTER TABLE incident_reports 
ADD COLUMN illegal_activity_detail varchar(225);

UPDATE incident_reports SET illegal_activity_detail= 'Group of people cut trees and stored them to a warehouse near ABC school' WHERE id=1;
INSERT INTO incident_reports (
    report_number,
    state,
    assigned_by,
    assigned_to,
    isAccepted,
    date_assigned,
    date_reported,
    reported_by,
    created_by,
    updated_by,
    activity_date,
    location,
    coordinate_lat,
    coordinate_lng
)
VALUES
(
    'REP92894262',
    'Open',
    'Admin',
    'Field Staff1',
    'Yes',
    '2024-10-17 21:28:07',
    '2024-10-12 21:28:07',
    'Concern citizen 1',
    'Staff1',
    NULL,  -- Assuming updated_by is nullable
    '2024-10-12 21:28:07',  -- Added missing activity_date
    'Real Calamba',
    '123.234567',
    '987.654321'
);
