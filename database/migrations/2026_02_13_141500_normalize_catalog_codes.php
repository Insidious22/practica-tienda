<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY status ENUM('active','inactive','discontinued','ACT','INA','DSC') NOT NULL DEFAULT 'active'");
        DB::statement("UPDATE products SET status = CASE status WHEN 'active' THEN 'ACT' WHEN 'inactive' THEN 'INA' WHEN 'discontinued' THEN 'DSC' ELSE status END");
        DB::statement("ALTER TABLE products MODIFY status ENUM('ACT','INA','DSC') NOT NULL DEFAULT 'ACT'");

        DB::statement("ALTER TABLE suppliers MODIFY status ENUM('active','inactive','ACT','INA') NOT NULL DEFAULT 'active'");
        DB::statement("UPDATE suppliers SET status = CASE status WHEN 'active' THEN 'ACT' WHEN 'inactive' THEN 'INA' ELSE status END");
        DB::statement("ALTER TABLE suppliers MODIFY status ENUM('ACT','INA') NOT NULL DEFAULT 'ACT'");

        DB::statement("UPDATE products SET unit = CASE LOWER(unit) WHEN 'unidad' THEN 'UNI' WHEN 'kg' THEN 'KGM' WHEN 'litro' THEN 'LTR' WHEN 'caja' THEN 'CAJ' WHEN 'set' THEN 'SET' WHEN 'paquete' THEN 'PAQ' ELSE UPPER(unit) END");
        DB::statement("ALTER TABLE products ALTER unit SET DEFAULT 'UNI'");

        DB::statement("UPDATE guardias SET tipo_documento = CASE LOWER(tipo_documento) WHEN 'cedula' THEN 'CED' WHEN 'ruc' THEN 'RUC' WHEN 'pasaporte' THEN 'PAS' WHEN 'otro' THEN 'OTR' ELSE UPPER(tipo_documento) END");
        DB::statement("UPDATE guardias SET turno = CASE UPPER(turno) WHEN 'MANANA' THEN 'MAN' WHEN 'TARDE' THEN 'TAR' WHEN 'NOCHE' THEN 'NOC' ELSE UPPER(turno) END");
        DB::statement("ALTER TABLE guardias ALTER tipo_documento SET DEFAULT 'CED'");

        DB::statement("UPDATE users SET document_type = CASE UPPER(document_type) WHEN 'CEDULA' THEN 'CED' WHEN 'RUC' THEN 'RUC' WHEN 'PASAPORTE' THEN 'PAS' WHEN 'OTRO' THEN 'OTR' ELSE UPPER(document_type) END");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY status ENUM('active','inactive','discontinued','ACT','INA','DSC') NOT NULL DEFAULT 'ACT'");
        DB::statement("UPDATE products SET status = CASE status WHEN 'ACT' THEN 'active' WHEN 'INA' THEN 'inactive' WHEN 'DSC' THEN 'discontinued' ELSE status END");
        DB::statement("ALTER TABLE products MODIFY status ENUM('active','inactive','discontinued') NOT NULL DEFAULT 'active'");

        DB::statement("ALTER TABLE suppliers MODIFY status ENUM('active','inactive','ACT','INA') NOT NULL DEFAULT 'ACT'");
        DB::statement("UPDATE suppliers SET status = CASE status WHEN 'ACT' THEN 'active' WHEN 'INA' THEN 'inactive' ELSE status END");
        DB::statement("ALTER TABLE suppliers MODIFY status ENUM('active','inactive') NOT NULL DEFAULT 'active'");

        DB::statement("UPDATE products SET unit = CASE unit WHEN 'UNI' THEN 'unidad' WHEN 'KGM' THEN 'kg' WHEN 'LTR' THEN 'litro' WHEN 'CAJ' THEN 'caja' WHEN 'SET' THEN 'set' WHEN 'PAQ' THEN 'paquete' ELSE LOWER(unit) END");
        DB::statement("ALTER TABLE products ALTER unit SET DEFAULT 'unidad'");

        DB::statement("UPDATE guardias SET tipo_documento = CASE tipo_documento WHEN 'CED' THEN 'cedula' WHEN 'RUC' THEN 'ruc' WHEN 'PAS' THEN 'pasaporte' WHEN 'OTR' THEN 'otro' ELSE LOWER(tipo_documento) END");
        DB::statement("UPDATE guardias SET turno = CASE turno WHEN 'MAN' THEN 'Manana' WHEN 'TAR' THEN 'Tarde' WHEN 'NOC' THEN 'Noche' ELSE turno END");
        DB::statement("ALTER TABLE guardias ALTER tipo_documento SET DEFAULT 'cedula'");

        DB::statement("UPDATE users SET document_type = CASE document_type WHEN 'CED' THEN 'CEDULA' WHEN 'RUC' THEN 'RUC' WHEN 'PAS' THEN 'PASAPORTE' WHEN 'OTR' THEN 'OTRO' ELSE document_type END");
    }
};
