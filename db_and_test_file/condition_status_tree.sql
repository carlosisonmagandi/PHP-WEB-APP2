CREATE TABLE condition_status_tree (
    id INT AUTO_INCREMENT PRIMARY KEY,
    condition_type VARCHAR(255),
    condition_description VARCHAR(255),
    activity_date VARCHAR(255),
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO condition_status_tree (condition_type, condition_description) VALUES
('Freshly Cut', 'Logs that have been recently cut down and are still relatively green and moist. These logs often have high moisture content and are heavier.'),
('Partially Processed', 'Logs that have been partially processed, such as being stripped of bark or cut into smaller sections, but not yet fully milled into lumber.'),
('Dry', 'Logs that have been cut for a while and have lost much of their moisture content. These are typically lighter and may have started to develop cracks or splits due to drying.'),
('Infested', 'Logs that show signs of infestation by insects such as termites, beetles, or other wood-boring pests. These logs may have visible holes, sawdust, or insect activity.'),
('Rotten/Decayed', 'Logs that have started to decompose due to fungal or bacterial activity. These logs may be soft, discolored, and structurally compromised.'),
('Damaged', 'Logs that have been damaged during harvesting, transport, or storage. This could include physical damage such as splits, cracks, or breakage.'),
('Illegally Harvested', 'Logs that have been cut from protected areas, without proper permits, or in violation of forestry regulations.'),
('Confiscated', 'Logs that have been seized by authorities due to illegal activities such as unauthorized logging or transportation.'),
('Branded/Marked', 'Logs that have been marked or branded by authorities or logging companies for identification purposes. These marks often indicate the origin, owner, or intended use of the logs.'),
('Stored/Stacked', 'Logs that have been stored in impounding areas, often stacked in piles for inventory and monitoring purposes. These logs might have varying conditions depending on how long they have been stored and the environmental conditions of the storage area.');
