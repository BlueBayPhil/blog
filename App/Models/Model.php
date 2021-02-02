<?php

namespace App\Models;

use App\Database\DB;

class Model
{
    public $id;
    public $created_at;

    protected $table = '';

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) $this->{$key} = $value;

        if (empty($this->table)) {
            // attempt to figure out what the table name should be
            $className = get_class($this);
            $this->table = strtolower(substr($className, strrpos($className, '\\') + 1));
            // Check for plural naming convention
            if (substr($this->table, strlen($this->table) - 1) != 's') {
                $this->table .= 's';
            }
        }
    }

    public static function find($id)
    {
        $result = DB::instance()->query("SELECT * FROM posts WHERE id='$id' LIMIT 1");

        if ($result->num_rows == 1) {
            return new static($result->fetch_assoc());
        }
    }

    public static function all(): array
    {
        $result = DB::instance()->query("SELECT * FROM posts");

        $output = [];
        while (null != ($row = $result->fetch_assoc())) {
            $output[] = new static($row);
        }

        return $output;
    }

    public function validate(): bool
    {
        return true;
    }

    public function save($attributes = [])
    {
        if (empty($this->table)) {
            die("Table not specified for model " . get_class($this));
        }
        if (!$this->validate()) {
            throw new \ValidationException();
        }
        if (!is_null($this->id)) {
            // update existing model
            // TODO
        } else {
            // create new model
            $data = get_object_vars($this);
            unset($data['table']);
            $fields = implode(',', array_keys($data));
            $field_placeholders = implode(',', array_map(function () {
                return '?';
            }, $data));

            $stmt = DB::instance()->prepare("INSERT INTO {$this->table}($fields) VALUES($field_placeholders)");

            if (!$stmt) {
                die(DB::instance()->error);
            }

            $stmt->bind_param(str_replace(['?', ','], ['s', ''], $field_placeholders), ...array_values($data));

            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                return true;
            } else {
                die($stmt->error);
                return false;
            }
        }
    }

    public function createdAt() : \DateTime {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }

    public function delete(): bool
    {
        if(!isset($this->id)) {
            return false;
        }

        $stmt = DB::instance()->prepare("DELETE FROM {$this->table} WHERE ID=? LIMIT 1");
        $stmt->bind_param('s', $this->id);

        return (bool) $stmt->execute();
    }
}