-- schema + seed data for User / Commande tests

CREATE TABLE IF NOT EXISTS `User` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` TEXT NOT NULL,
    `email` TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS `Commande` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `userId` INTEGER NOT NULL,
    `product` TEXT NOT NULL,
    `amount` DECIMAL NOT NULL,
    FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
);
