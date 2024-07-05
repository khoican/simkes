<?php
namespace App\Validation;

class CustomRules
{
    public function is_unique_except_self(string $str, string $field, array $data, string &$error = null): bool
    {
        list($table, $column) = explode('.', $field);
        $id = $data['id'] ?? null;

        if (!$id) {
            $error = 'ID is required for the unique check.';
            return false;
        }

        $db = db_connect();
        $result = $db->table($table)
                     ->where($column, $str)
                     ->where('id !=', $id)
                     ->countAllResults();

        if ($result == 0) {
            return true;
        }

        $error = "The $column field must contain a unique value.";
        return false;
    }
}