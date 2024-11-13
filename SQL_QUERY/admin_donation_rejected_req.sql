CREATE TABLE admin_donation_rejected_req(
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    reject_reason VARCHAR(255) ,
    rejected_by VARCHAR(255),
    rejected_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES request_form(id) ON DELETE CASCADE
);

SELECT * FROM admin_donation_rejected_req;
DELETE FROM admin_donation_rejected_req WHERE ID IN(16,17,18);

ALTER TABLE admin_donation_rejected_req
ADD COLUMN rejected_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;