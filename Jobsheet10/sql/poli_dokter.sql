-- Jobsheet 8: skema awal database polimedic (PostgreSQL)
-- Jalankan setelah membuat database, misal:
--   createdb polimedic_db
--   psql -d polimedic_db -f sql/poli_dokter.sql

CREATE TABLE IF NOT EXISTS poli (
    id SERIAL PRIMARY KEY,
    nama_poli VARCHAR(255) NOT NULL,
    gedung VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS dokter (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    spesialis VARCHAR(255) NOT NULL,
    telepon VARCHAR(50) NOT NULL
);