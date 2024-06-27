CREATE TABLE security_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer VARCHAR(255) NOT NULL,
    account_id INT NOT NULL,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activity_date DATE,
    FOREIGN KEY (account_id) REFERENCES account(id)
);

ALTER TABLE security_questions
RENAME COLUMN question TO question1;

ALTER TABLE security_questions
ADD COLUMN question2 VARCHAR(255) NOT NULL AFTER question1;

ALTER TABLE security_questions
RENAME COLUMN answer TO answer1;

ALTER TABLE security_questions
ADD COLUMN answer2 VARCHAR(255) NOT NULL AFTER answer1;