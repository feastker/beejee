<?php

class Model
{

    protected $item;

    function __construct($id = false)
    {
        if (!empty($id)) {
            $this->item = $this->get(false, ['id' => $id]);
        }
    }

    function exist()
    {
        return empty($this->item) ? false : true;
    }

    function getProp($property)
    {
        return $this->item->{$property};
    }

    function setProp($property, $value)
    {
        $this->update([$property => $value]);
    }

    function update($data)
    {
        if (empty($this->item)) {
            return false;
        }

        $update_query = 'UPDATE `' . $this->table . '` SET ' . implode(', ', array_map(function ($field) {
                return '`' . $field . '` = ?';
            }, array_keys($data))) . ' WHERE id = ' . $this->item->id;

        DB::insert($update_query, array_values($data));

        return true;
    }

    function getCount()
    {
        $select_query = 'SELECT COUNT(*) ct FROM `' . $this->table . '`';
        $result = DB::select($select_query);
        return $result->ct;
    }

    function get($fields, $conditions = [], $order = 'id ASC', $offset = 0, $limit = 3, $multiple = false)
    {
        $select_query = 'SELECT ' . (empty($fields) ? '*' : implode(',', $fields));
        $select_query .= ' FROM `' . $this->table . '`';

        if (!empty($conditions)) {
            $select_query .= ' WHERE ' . implode(' AND ', array_map(function ($field) {
                    return '`' . $field . '` = ?';
                }, array_keys($conditions)));
        }

        if ($multiple) {
            if (!empty($order)) {
                $select_query .= ' ORDER BY ' . $order;
            }

            $select_query .= ' LIMIT ' . $offset . ', ' . $limit;
        }

        $result = DB::select($select_query, array_values($conditions), $multiple);

        return $result;
    }

    function add($data)
    {

        $insert_query = 'INSERT INTO ' . $this->table . '(' . implode(',',
                array_keys($data)) . ') VALUES (' . implode(',', array_map(function () {
                return '?';
            }, $data)) . ')';

        return DB::insert($insert_query, array_values($data));
    }
}