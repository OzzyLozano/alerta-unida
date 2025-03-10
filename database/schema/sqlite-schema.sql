CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "lastname" varchar not null,
  "email" varchar not null,
  "password" varchar not null,
  "type" varchar check("type" in('maestro', 'estudiante')) not null default 'estudiante',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "alerts"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "content" text not null,
  "type" varchar check("type" in('evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios')) not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "brigade"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "lastname" varchar not null,
  "email" varchar not null,
  "password" varchar not null,
  "training" varchar check("training" in('evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios')) not null,
  "role" varchar check("role" in('lider', 'miembro')) not null default 'miembro',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "brigade_email_unique" on "brigade"("email");
CREATE TABLE IF NOT EXISTS "simulacrum"(
  "id" integer primary key autoincrement not null,
  "title" varchar not null,
  "type" varchar check("type" in('evacuacion', 'prevencion/combate de fuego', 'busqueda y rescate', 'primeros auxilios')) not null,
  "created_at" datetime,
  "updated_at" datetime
);

INSERT INTO migrations VALUES(1,'2025_03_07_093558_create_users_table',1);
INSERT INTO migrations VALUES(2,'2025_03_09_214456_create_alerts_table',1);
INSERT INTO migrations VALUES(3,'2025_03_09_215534_create_brigadistas_table',1);
INSERT INTO migrations VALUES(4,'2025_03_10_003137_create_simulacrum_table',1);
