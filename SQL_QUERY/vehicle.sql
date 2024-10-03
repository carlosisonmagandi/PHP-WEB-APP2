CREATE TABLE vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_name VARCHAR(255),
    vehicle_type VARCHAR(255),
    plate_no VARCHAR(255),
    brand VARCHAR(255),
    model VARCHAR(255),
    vehicle_status VARCHAR(255),
    location VARCHAR(255),
    date_of_compiscation VARCHAR(255),
    vehicle_owner VARCHAR(255),
    vehicle_condition VARCHAR(255),
    remarks VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(255),
    updated_by VARCHAR(255)
);


INSERT INTO vehicles (
vehicle_name,
vehicle_type ,
    plate_no ,
    brand ,
    model ,
    vehicle_status ,
    location ,
    date_of_compiscation ,
    vehicle_owner,
    vehicle_condition ,
    remarks,
    created_by ,
    updated_by ,
    confiscated_by

)VALUES(
'Closed Van',
'SUV',
'HOK102V',
'Hundai',
'2021',
'Impounded',
'Real Calamba',
'09-24-2023',
'Gerome',
'Good condition',
'Needs to investigate',
'Kian',
'Kian',
'Joe'
);

SELECT * FROM vehicles;
ALTER TABLE vehicles
ADD COLUMN confiscated_by VARCHAR(255);

