CREATE TABLE request_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    file_name VARCHAR(255) ,
    file_path VARCHAR(255) ,
    created_by VARCHAR(255),
    updated_by VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES request_form(id) ON DELETE CASCADE
);

SELECT * FROM request_documents;
delete from request_documents where request_id IN (3);