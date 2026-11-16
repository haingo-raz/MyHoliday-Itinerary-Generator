CREATE TABLE IF NOT EXISTS destination (
    destination_id SERIAL PRIMARY KEY,
    img_url        TEXT,
    country        VARCHAR(50),
    location       VARCHAR(50),
    activity       VARCHAR(50),
    duration       INTEGER,
    price          INTEGER,
    site_url       TEXT
);

CREATE TABLE IF NOT EXISTS added_destination (
    id              SERIAL PRIMARY KEY,
    added_location  VARCHAR(255),
    added_activity  VARCHAR(255) UNIQUE,
    added_duration  INTEGER,
    added_price     INTEGER
);
