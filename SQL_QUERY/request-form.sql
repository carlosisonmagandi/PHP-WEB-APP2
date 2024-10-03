CREATE TABLE request_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_number VARCHAR(255),
    created_by VARCHAR(255),
    updated_by VARCHAR(255),
    activity_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    requestor_name VARCHAR(255),
    organization_name VARCHAR(255),
    phone_number VARCHAR(255),
    email VARCHAR(255),
    address VARCHAR(255),
    type_of_requested_item VARCHAR(255),
    quantity VARCHAR(255),
    request_description VARCHAR(255),
    purpose_of_donation VARCHAR(255),
    preferred_delivery_date VARCHAR(255),
    preferred_delivery_time VARCHAR(255),
    delivery_address VARCHAR(255),
    special_instructions VARCHAR(255),
    reason_of_request VARCHAR(255),
    previous_donations VARCHAR(255),
    additional_comments VARCHAR(255)
);

SELECT * FROM request_form;
UPDATE  request_form SET request_number='RE000000123' where id=1;

INSERT INTO request_form (
    created_by,
    updated_by,
    requestor_name,
    organization_name,
    phone_number,
    email,
    address,
    type_of_requested_item,
    quantity,
    request_description,
    purpose_of_donation,
    preferred_delivery_date,
    preferred_delivery_time,
    delivery_address,
    special_instructions,
    reason_of_request,
    previous_donations,
    additional_comments
) VALUES (
    'John Doe',                    -- created_by
    'John Doe',                    -- updated_by
    'Alice Smith',                 -- requestor_name
    'Green Earth Org',             -- organization_name
    '123-456-7890',                -- phone_number
    'alice.smith@greenearth.org',  -- email
    '123 Oak Street, Springfield', -- address
    'Laptops',                     -- type_of_requested_item
    '15',                          -- quantity
    'Laptops for rural schools',   -- request_description
    'To support education in rural areas', -- purpose_of_donation
    '2024-10-05',                  -- preferred_delivery_date
    '10:00 AM',                    -- preferred_delivery_time
    '456 Elm Street, Springfield', -- delivery_address
    'Contact before delivery',     -- special_instructions
    'To expand existing educational support', -- reason_of_request
    '5 laptops in 2023',           -- previous_donations
    'Looking for energy-efficient models' -- additional_comments
);

INSERT INTO request_form (
    request_number,
    created_by,
    updated_by,
    requestor_name,
    organization_name,
    phone_number,
    email,
    address,
    type_of_requested_item,
    quantity,
    request_description,
    purpose_of_donation,
    preferred_delivery_date,
    preferred_delivery_time,
    delivery_address,
    special_instructions,
    reason_of_request,
    previous_donations,
    additional_comments
) VALUES (
    'RE000000124',                -- request_number
    'Jane Doe',                   -- created_by
    'Jane Doe',                   -- updated_by
    'Bob Williams',               -- requestor_name
    'Clean Water Initiative',     -- organization_name
    '987-654-3210',               -- phone_number
    'bob.w@cleanwater.org',       -- email
    '789 Pine Street, Springfield', -- address
    'Water Filters',              -- type_of_requested_item
    '25',                         -- quantity
    'Water filters for remote communities', -- request_description
    'To provide clean drinking water',      -- purpose_of_donation
    '2024-10-15',                 -- preferred_delivery_date
    '2:00 PM',                    -- preferred_delivery_time
    '101 Maple Avenue, Springfield', -- delivery_address
    'Please deliver between 2-4 PM', -- special_instructions
    'Urgent need due to contamination', -- reason_of_request
    '10 filters in 2022',         -- previous_donations
    'Looking for portable models' -- additional_comments
);

INSERT INTO request_form (
    request_number,
    created_by,
    updated_by,
    requestor_name,
    organization_name,
    phone_number,
    email,
    address,
    type_of_requested_item,
    quantity,
    request_description,
    purpose_of_donation,
    preferred_delivery_date,
    preferred_delivery_time,
    delivery_address,
    special_instructions,
    reason_of_request,
    previous_donations,
    additional_comments
) VALUES (
    'RE000000125',                 -- request_number
    'Michael Scott',               -- created_by
    'Michael Scott',               -- updated_by
    'Pam Beesly',                  -- requestor_name
    'Dunder Mifflin',              -- organization_name
    '123-987-6543',                -- phone_number
    'pam.beesly@dundermifflin.com',-- email
    '1725 Slough Avenue, Scranton',-- address
    'Office Chairs',               -- type_of_requested_item
    '20',                          -- quantity
    'Chairs for conference rooms', -- request_description
    'To upgrade office furniture', -- purpose_of_donation
    '2024-11-05',                  -- preferred_delivery_date
    '1:00 PM',                     -- preferred_delivery_time
    '1725 Slough Avenue, Scranton',-- delivery_address
    'Please assemble upon delivery',-- special_instructions
    'Office renovation',           -- reason_of_request
    'N/A',                         -- previous_donations
    'Looking for ergonomic models' -- additional_comments
);

ALTER TABLE request_form
ADD COLUMN request_number VARCHAR(255);

ALTER TABLE request_form
ADD COLUMN approval_status VARCHAR(255);

ALTER TABLE request_form
ADD COLUMN cancellation_reason VARCHAR(255);

ALTER TABLE request_form
ADD COLUMN name_of_requested_item VARCHAR(255);

ALTER TABLE request_form
DROP COLUMN reason_of_request,
DROP COLUMN previous_donations,
DROP COLUMN additional_comments;

ALTER TABLE request_form
ADD COLUMN letter_of_intent VARCHAR(255),
ADD COLUMN project_eng_certification VARCHAR(255),
ADD COLUMN budget_officer_certification VARCHAR(255);
    

select * FROM request_form;

DELETE FROM request_form where id in (47,48);

SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='request_form' AND table_schema = DATABASE();
DESC request_form;


UPDATE request_form SET approval_status='Pending for Approval' WHERE id in(1,2,3);

UPDATE request_form SET type_of_requested_item='T' WHERE id in(1);
UPDATE request_form SET name_of_requested_item='Bolo Knife' WHERE id in(2);
UPDATE request_form SET created_by='kian' WHERE id in(1,2,3);