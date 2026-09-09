-- Users
INSERT INTO `User` (`name`, `email`) VALUES
    ('Alice Martin', 'alice@example.com'),
    ('Bob Dupont', 'bob@example.com'),
    ('Charlie Smith', 'charlie@example.com');

-- Commandes
INSERT INTO `Commande` (`userId`, `product`, `amount`) VALUES
    (1, 'Laptop', 1299.99),
    (1, 'Wireless Mouse', 29.99),
    (2, 'Mechanical Keyboard', 89.50),
    (2, 'USB-C Hub', 45.00),
    (3, 'Monitor', 349.99),
    (3, 'Webcam', 79.90);
