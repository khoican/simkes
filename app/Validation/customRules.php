<?php

namespace App\Validation;

class CustomRules
{
    public function is_unique_except_self(string $str, string $field, array $data, string &$error = null): bool
    {
        list($table, $column) = explode('.', $field);
        $id = $data['id'] ?? null;

        $db = db_connect();
        $builder = $db->table($table)
                      ->where($column, $str);

        if ($id) {
            $builder->where('id !=', $id);
        }

        $result = $builder->countAllResults();

        if ($result == 0) {
            return true;
        }

        $error = "$column sudah terdaftar, periksa kembali $column anda";
        return false;
    }
}