<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->date_now = date("Y-m-d H:i:s");
  }

  private function _populate_fields($data, $mode = '')
  {
    $fields = $data;
    if (count($this->fillable)) {
      $fields = [];
      foreach ($this->fillable as $val) {
        if (isset($data[$val])) {
          $fields[$val] = $data[$val];
        }
      }
    }

    if ($mode == "insert") {
      $fields['created_at'] = $this->date_now;
      if (isset($data['created_by'])) {
        $fields['created_by'] = $data['created_by'];
      }
    }

    // Column updated_at is automatically CURRENT_TIMESTAMP
    if ($mode == "update" && isset($data['updated_by'])) {
      $fields['updated_by'] = $data['updated_by'];
    }
    return $fields;
  }

  public function get($id)
  {
    $this->db->where([
      $this->primary_key => $id,
      'deleted_at' => null
    ]);
    return $this->db->get($this->table);
  }

  public function get_where($where)
  {
    return $this->db->get_where($this->table, $where);
  }

  public function insert($data = [])
  {
    if (empty($data)) {
      return false;
    }

    $fields = $this->_populate_fields($data, 'insert');
    return $this->db->insert($this->table, $fields);
  }

  public function update($data = [], $id)
  {
    $fields = $this->_populate_fields($data, 'update');
    return $this->db->update($this->table, $fields, [$this->primary_key => $id]);
  }

  public function delete($id)
  {
    return $this->db->update($this->table, ['deleted_at' => $this->date_now], [$this->primary_key => $id]);
  }
}
