CREATE TABLE users
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(255)        NOT NULL,
    email         VARCHAR(255) UNIQUE NOT NULL,
    mobile_number INT                 NOT NULL,
    address       VARCHAR(128) DEFAULT NULL,
    city          VARCHAR(128) DEFAULT NULL,
    state         VARCHAR(2)   DEFAULT NULL,
    zip           INT          DEFAULT NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    last_updated  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);