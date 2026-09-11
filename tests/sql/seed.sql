-- schema + seed data for User / Commande tests

CREATE TABLE "User" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "username" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "role" TEXT NOT NULL DEFAULT 'member' CHECK ("role" IN ('admin', 'member'))
);

CREATE TABLE "Event" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "title" TEXT NOT NULL,
    "description" TEXT NOT NULL,
    "event_date" DATETIME NOT NULL,
    "capacity" INTEGER NOT NULL CHECK ("capacity" >= 0),
    "owner_id" INTEGER NOT NULL,
    CONSTRAINT fk_event_user
        FOREIGN KEY ("owner_id") REFERENCES "User"("id")
        ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE "Registration" (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "user_id" INTEGER NOT NULL,
    "event_id" INTEGER NOT NULL,
    "created_at" DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_registration_user
        FOREIGN KEY ("user_id") REFERENCES "User"("id")
        ON DELETE CASCADE ON UPDATE RESTRICT,
    CONSTRAINT fk_registration_event
        FOREIGN KEY ("event_id") REFERENCES "Event"("id")
        ON DELETE CASCADE ON UPDATE RESTRICT
);