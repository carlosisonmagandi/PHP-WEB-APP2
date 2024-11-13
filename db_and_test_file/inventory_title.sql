-- Create new account table 
CREATE TABLE inventory_title (	
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activity_date date NOT NULL, 
    percentage INT(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    cy_year date NOT NULL
);

ALTER TABLE inventory_title
ADD COLUMN cy_end_year INT;

ALTER TABLE inventory_title
CHANGE COLUMN cy_year cy_start_year VARCHAR(255);

ALTER TABLE inventory_title
MODIFY COLUMN activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;


SELECT * from inventory_title;
INSERT INTO inventory_title(percentage,title,cy_start_year,cy_end_year) 
VALUES("100","INVENTORY OF APPREHENDED/CONFISCATED FOREST PRODUCT/CONVEYANCES
AND OTHER IMPLEMENTS DEPOSITED AT THE IMPOUNDING AREA OF PENRO LAGUNA AS OF CY","2018","2024");