USE clockwise;

CREATE TABLE break_entries
(
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED NOT NULL,
    clock_id    INT UNSIGNED NOT NULL,
    started_at  DATETIME NOT NULL,
    ended_at    DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id)  REFERENCES users(id),
    FOREIGN KEY (clock_id) REFERENCES clock_entries(id)
);
