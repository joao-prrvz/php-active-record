-- =========================================================
-- USERS
-- Password for every account: Super
-- generated from the password "Super".
-- =========================================================

INSERT INTO "User" ("id", "username", "password", "role") VALUES
(1, 'admin',   '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'admin'),
(2, 'alice',   '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(3, 'bob',     '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(4, 'charlie', '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(5, 'diana',   '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(6, 'eric',    '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(7, 'fiona',   '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member'),
(8, 'george',  '$2a$12$HN7YCkjTw70BHNVmEIiiS.fc4AA7J4ldbZ59o9U323v1qjmvXQRDu', 'member');


-- =========================================================
-- EVENTS
-- Different hours are intentionally used.
-- =========================================================

INSERT INTO "Event"
("id", "title", "description", "event_date", "capacity", "owner_id")
VALUES

(1,
 'Summer Networking Evening',
 'An informal networking evening for members to meet and exchange ideas.',
 date('now', '+1 day') || ' 18:00:00',
 50,
 1),

(2,
 'Web Development Workshop',
 'A practical workshop covering modern web development techniques.',
 date('now', '+3 day') || ' 14:00:00',
 30,
 2),

(3,
 'Community Picnic',
 'A relaxed outdoor picnic for members and their friends.',
 date('now', '+5 day') || ' 12:30:00',
 80,
 3),

(4,
 'Introduction to Databases',
 'Learn the fundamentals of relational databases, SQL, and database design.',
 date('now', '+7 day') || ' 10:00:00',
 40,
 1),

(5,
 'Photography Walk',
 'A guided photography walk through the city with fellow photography enthusiasts.',
 date('now', '+10 day') || ' 16:00:00',
 20,
 4),

(6,
 'Game Night',
 'An evening of board games, card games, and friendly competition.',
 date('now', '+13 day') || ' 19:30:00',
 35,
 5),

(7,
 'Tech Careers Meetup',
 'Meet other professionals and discuss careers, skills, and opportunities in technology.',
 date('now', '+16 day') || ' 18:30:00',
 60,
 2),

(8,
 'SQL Practice Session',
 'Hands-on SQL exercises covering SELECT, JOIN, GROUP BY, and subqueries.',
 date('now', '+19 day') || ' 15:00:00',
 25,
 6),

(9,
 'Autumn Planning Meeting',
 'A planning session for upcoming community events and activities.',
 date('now', '+23 day') || ' 11:00:00',
 30,
 1),

(10,
 'Hackathon',
 'A full-day collaborative coding event where members build projects together.',
 date('now', '+31 day') || ' 09:00:00',
 100,
 1);

-- =========================================================
-- REGISTRATIONS
-- =========================================================

INSERT INTO "Registration" ("user_id", "event_id", "created_at")
VALUES

-- Summer Networking Evening
(2, 1, '2026-08-20 09:15:00'),
(3, 1, '2026-08-20 09:30:00'),
(4, 1, '2026-08-20 10:00:00'),
(5, 1, '2026-08-20 10:20:00'),

-- Web Development Workshop
(3, 2, '2026-08-20 08:30:00'),
(5, 2, '2026-08-20 09:10:00'),
(6, 2, '2026-08-20 09:45:00'),

-- Community Picnic
(2, 3, '2026-08-20 08:00:00'),
(4, 3, '2026-08-20 08:20:00'),
(7, 3, '2026-08-20 09:00:00'),
(8, 3, '2026-08-20 09:30:00'),

-- Introduction to Databases
(2, 4, '2026-08-20 10:00:00'),
(3, 4, '2026-08-20 10:15:00'),
(6, 4, '2026-08-20 10:30:00'),

-- Photography Walk
(4, 5, '2026-08-20 11:00:00'),
(7, 5, '2026-08-20 11:15:00'),

-- Game Night
(2, 6, '2026-08-20 09:40:00'),
(3, 6, '2026-08-20 10:05:00'),
(5, 6, '2026-08-20 10:40:00'),
(8, 6, '2026-08-20 11:00:00'),

-- Tech Careers Meetup
(2, 7, '2026-08-20 08:50:00'),
(4, 7, '2026-08-20 09:20:00'),
(6, 7, '2026-08-20 09:50:00'),
(7, 7, '2026-08-20 10:20:00'),

-- SQL Practice Session
(3, 8, '2026-08-20 10:10:00'),
(5, 8, '2026-08-20 10:35:00'),
(8, 8, '2026-08-20 11:05:00'),

-- Autumn Planning Meeting
(2, 9, '2026-08-20 09:05:00'),
(3, 9, '2026-08-20 09:25:00'),
(4, 9, '2026-08-20 09:45:00'),

-- Hackathon
(2, 10, '2026-08-20 08:15:00'),
(3, 10, '2026-08-20 08:45:00'),
(4, 10, '2026-08-20 09:15:00'),
(5, 10, '2026-08-20 09:45:00'),
(6, 10, '2026-08-20 10:15:00'),
(7, 10, '2026-08-20 10:45:00'),
(8, 10, '2026-08-20 11:15:00');