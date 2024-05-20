CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_of_apprehension DATE,
    sitio VARCHAR(225),
   barangay VARCHAR(225),
   city_municipality VARCHAR(225),
   province VARCHAR(225),
   apprehending_officer VARCHAR(225),
   apprehended_items VARCHAR(500),
   EMV_forest_product VARCHAR(225),
   EMV_conveyance_implements VARCHAR(225),
   involve_personalities VARCHAR(225),
   custodian VARCHAR(225),
   ACP_status_or_case_no VARCHAR(225),
   date_of_confiscation_order DATE,
   remarks VARCHAR(225),
   apprehended_persons VARCHAR(225)
);
select * from inventory;

ALTER TABLE inventory
MODIFY COLUMN date_of_apprehension VARCHAR(225),
MODIFY COLUMN date_of_confiscation_order VARCHAR(225);
