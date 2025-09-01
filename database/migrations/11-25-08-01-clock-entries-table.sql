USE clockwise;

CREATE TABLE clock_entries
(
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id   INT UNSIGNED NOT NULL,
    clock_in  DATETIME NOT NULL,
    clock_out DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
);
