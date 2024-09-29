CREATE TABLE map_coordinates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    inventory_id INT NOT NULL,
    longitude VARCHAR(255) NOT NULL,
    latitude VARCHAR(255) NOT NULL,
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(255) NOT NULL,
    updated_by VARCHAR(255) NOT NULL,
    FOREIGN KEY (inventory_id) REFERENCES inventory(id) ON DELETE CASCADE
);

INSERT INTO map_coordinates (inventory_id,longitude,latitude,created_by,updated_by) VALUES(145,'121.17842603410668','14.19135422831107','Carlo','Carlo');
SELECT * FROM map_coordinates where inventory_id=145;
INSERT INTO map_coordinates (inventory_id,longitude,latitude,created_by) VALUES(145,'121.17842603410668','14.19135422831107','Carlo');


DELETE FROM map_coordinates where id in(6,7);

ALTER TABLE map_coordinates
MODIFY COLUMN created_by VARCHAR(255),
MODIFY COLUMN updated_by VARCHAR(255);

ALTER TABLE map_coordinates
DROP COLUMN request_number;

