CREATE TABLE participations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paypal_transaction_id VARCHAR(255) NOT NULL COMMENT 'Unique PayPal transaction ID for the payment',
    nickname VARCHAR(255) NOT NULL COMMENT 'Name or nickname of the participant',
    twitter_account VARCHAR(255) NULL COMMENT 'Participant''s Twitter account (optional)',
    instagram_account VARCHAR(255) NULL COMMENT 'Participant''s Instagram account (optional)',
    email_address VARCHAR(255) NOT NULL COMMENT 'Participant''s email address for contact',
    participation_date DATETIME NOT NULL COMMENT 'Date and time of participation submission',
    verified BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Verified payment is OK',
    INDEX idx_email (email_address) COMMENT 'Index on email_address for faster lookups'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stores raffle participation entries';
