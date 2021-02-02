<?php

namespace App\Models;

use App\Database\DB;
use DateTime;
use ValidationException;

class Model
{
    public int $id;
    public string $created_at;

    /**
     * Optionally override the table used in queries
     * @var string
     */
    protected string $table = '';

    /**
     * Model constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) $this->{$key} = $value;

        if (empty($this->table)) {
            // Attempt to figure out what the table we should use is called.
            $className = get_class($this);
            $this->table = strtolower(substr($className, strrpos($className, '\\') + 1));
            // Check for plural naming convention
            if (substr($this->table, strlen($this->table) - 1) != 's') {
                $this->table .= 's';
            }
        }
    }

    /**
     * Find a new resource
     * @param $id
     * @return static
     */
    public static function find($id)
    {
        $result = DB::instance()->query("SELECT * FROM posts WHERE id='$id' LIMIT 1");

        if ($result->num_rows == 1) {
            return new static($result->fetch_assoc());
        }
    }

    /**
     * Find all objects from the database
     * @return array
     */
    public static function all(): array
    {
        $result = DB::instance()->query("SELECT * FROM posts");

        $output = [];
        while (null != ($row = $result->fetch_assoc())) {
            $output[] = new static($row);
        }

        return $output;
    }

    /**
     * Validate the submitted data
     * @virtual
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }

    /**
     * Save the object to the database
     * @param array $attributes
     * @return bool
     * @throws ValidationException
     */
    public function save($attributes = []): bool
    {
        if (empty($this->table)) {
            die("Table not specified for model " . get_class($this));
        }
        if (!$this->validate()) {
            throw new ValidationException();
        }

        $data = get_object_vars($this);
        // Remove the table name from data props.
        unset($data['table']);

        if (!is_null($this->id)) {
            // Update an existing model.
            // Remove the id and created_at fields so we dont update them.
            unset($data['id'], $data['created_at']);
            $update_fields = implode(',', array_map(function ($k) {
                return sprintf("%s=?", $k);
            }, array_keys($data)));

            $stmt = DB::instance()->prepare("UPDATE {$this->table} SET {$update_fields} WHERE id=? LIMIT 1");
            $stmt->bind_param('ssss', ...array_merge(array_values($data), [$this->id]));
        } else {
            // Create a new model.
            $fields = implode(',', array_keys($data));
            $field_placeholders = implode(',', array_map(function () {
                return '?';
            }, $data));

            $stmt = DB::instance()->prepare("INSERT INTO {$this->table}($fields) VALUES($field_placeholders)");
            $stmt->bind_param(str_replace(['?', ','], ['s', ''], $field_placeholders), ...array_values($data));
        }

        if (!$stmt) {
            die(DB::instance()->error);
        }

        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the created_at property as a DateTime object
     * @return DateTime
     */
    public function createdAt(): DateTime
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
    }

    /**
     * Delete the object from the database
     * @return bool
     */
    public function delete(): bool
    {
        if (!isset($this->id)) {
            return false;
        }

        $stmt = DB::instance()->prepare("DELETE FROM {$this->table} WHERE ID=? LIMIT 1");
        $stmt->bind_param('s', $this->id);

        return (bool)$stmt->execute();
    }
}