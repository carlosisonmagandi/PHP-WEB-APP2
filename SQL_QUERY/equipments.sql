CREATE TABLE equipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name VARCHAR(255),
    equipment_type VARCHAR(255),
    serial_no VARCHAR(255),
    brand VARCHAR(255),
    model VARCHAR(255),
    equipment_status VARCHAR(255),
    location VARCHAR(255),
    date_of_compiscation VARCHAR(255),
    equipment_owner VARCHAR(255),
    equipment_condition VARCHAR(255),
    remarks VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO equipments (
    equipment_name,
    equipment_type,
    serial_no,
    brand,
    model,
    equipment_status,
    location,
    date_of_compiscation,
    equipment_owner,
    equipment_condition,
    remarks
) 
VALUES (
    'Chainsaw',
    'Cutting',
    'SN123456',
    'Stihl',
    'MS 880',
    'Confiscated',
    'Forest Region A',
    '2024-09-07',
    'John Doe',
    'Good',
    'Illegal logging operation'
);


SELECT * FROM equipments;
DELETE FROM equipments where id in(6,7,8);

ALTER TABLE equipments
ADD COLUMN created_by VARCHAR(255),
ADD COLUMN updated_by VARCHAR(255);

ALTER TABLE equipments
ADD COLUMN category_type VARCHAR(255);

UPDATE equipments SET category_type='equipment' where id IN(2,12);
