CREATE TABLE account (	
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   --  FOREIGN KEY (role_id) REFERENCES userrole(id),
    role VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'inactive',
    activity_date date NOT NULL 
);


INSERT INTO account (username, password, role) 
VALUES ('admin', 'myPassword', 'Admin');