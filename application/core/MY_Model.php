<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ------------------------------
 * MY_Model - Simple overriding
 * ------------------------------
 * 
 * NOTES:
 * 
 * Select query methods:
 * • select()
 * • join()
 * • conditions()
 * • where()
 * • get_all()
 * 
 * is best executed in their sequential order as how it is written.
 */

class MY_Model extends CI_Model
{
	public $page;
	public $limit;
	public $offset;
	public $total;
	public $no_of_pages;
	public $soft_delete = TRUE;

	public function __construct()
	{
		parent::__construct();
        $this->_prep_data();
		$this->page = $this->input->post('page') ? (int) $this->input->post('page') : 1;
		$this->limit = $this->input->post('limit') ? (int) $this->input->post('limit') : 25;
		$this->offset = $this->limit * ($this->page - 1);
		$this->no_of_pages = 0;
		$this->total = 0;
	}

    private function _prep_data()
    {
        // Sanitize all POST variable
        if ($this->input->post()) {
            $_POST = array_map('trim', $_POST);
            foreach ($_POST as $key => $value) {
                if ($_POST[$key] == NULL OR strlen($_POST[$key]) == 0) unset($_POST[$key]);
            }
        }

        // Sanitize all GET variable
        if ($this->input->get()) {
            $_GET = array_map('trim', $_GET);
            foreach ($_GET as $key => $value) {
                if ($_GET[$key] == NULL OR strlen($_GET[$key]) == 0) unset($_GET[$key]);
            }
        }
        
        // json pushed to POST variables
        if ($this->input->raw_input_stream) {
            $stream_clean = json_decode($this->security->xss_clean($this->input->raw_input_stream), TRUE);
            if ($_POST) $_POST = array_merge($_POST, $stream_clean);
            else $_POST = $stream_clean;
        }
        // $this->_set_session();
    }

	/**
	 * -------------------------
	 * OPTIONAL SELECT METHOD
	 * (same as DB->select())
	 * -------------------------
	 */
	public function select($fields = '*')
	{
		$this->db->select($fields);
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL JOIN METHOD
	 * (same as native join)
	 * -------------------------
	 */
	public function join($table, $on, $type = NULL)
	{
		if ($type) $this->db->join($table, $on, $type);
		else $this->db->join($table, $on);
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL CONDITIONS METHOD
	 * (same as old _set_where in previous projects)
	 * -------------------------
	 */
	public function conditions()
	{
		if ($this->input->post('date_from') && $this->input->post('date_to')) {
			$this->db->where([
				$this->table . '.created_at >=' => $this->input->post('date_from') . ' 00:00:00',
				$this->table . '.created_at <=' => $this->input->post('date_to') . ' 23:59:59'
			]);
		}
	
		if ($this->input->post('column') && $this->input->post('keyword')) {
			$this->db->group_start();
			foreach (explode('|', $this->input->post('column')) as $key => $column) {
				$this->db->or_like([$column => $this->input->post('keyword')]);
			}
			$this->db->group_end();
		}
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL GROUP START
	 * (same as native group_start)
	 * -------------------------
	 */
	public function group_start()
	{
		$this->db->group_start();
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL GROUP START
	 * (same as native group_start)
	 * -------------------------
	 */
	public function or_group_start()
	{
		$this->db->or_group_start();
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL GROUP START
	 * (same as native group_start)
	 * -------------------------
	 */
	public function group_end()
	{
		$this->db->group_end();
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL LIKE METHOD
	 * (same as native where)
	 * -------------------------
	 */
	public function like($conditions)
	{
		$this->db->like($conditions);
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL OR LIKE METHOD
	 * (same as native where)
	 * -------------------------
	 */
	public function or_like($conditions)
	{
		$this->db->or_like($conditions);
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL WHERE METHOD
	 * (same as native where)
	 * -------------------------
	 */
	public function where($conditions)
	{
		$this->db->where($conditions);
		return $this;
	}

	/**
	 * -------------------------
	 * OPTIONAL OR WHERE METHOD
	 * (same as native where)
	 * -------------------------
	 */
	public function or_where($conditions)
	{
		$this->db->or_where($conditions);
		return $this;
	}

	/**
	 * -------------------------
	 * SELECT ROWS - multiple
	 * -------------------------
	 */
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = NULL, $get_users = NULL)
	{
		$results = [];

		if (! $with_trashed && $this->soft_delete) {
			$this->db->where($this->table . '.deleted_at IS NULL');
		}

		$this->conditions();
		if ($paginate) {
			$tempdb = clone $this->db;
			$this->total = $tempdb->from($this->table)->count_all_results();
			$this->no_of_pages = (ceil($this->total / $this->limit));
			$this->db->limit($this->limit, $this->offset);
		}
		$this->db->from($this->table);

		if ($this->input->post('order_by_column') && $this->input->post('order_by_asc') && in_array(strtolower($this->input->post('order_by_asc')), ['asc', 'desc']))
			$this->db->order_by($this->input->post('order_by_column') . ' ' . strtoupper($this->input->post('order_by_asc')));
		else if ($order_by)
			$this->db->order_by($order_by);
		else
			$this->db->order_by($this->table . '.updated_at DESC');

		$results = $this->db->get()->result();
		return $results;
	}

	/**
	 * -------------------------
	 * SELECT ROW - single
	 * -------------------------
	 */
	public function get($id = NULL, $with_trashed = FALSE)
	{
		$this->db->from($this->table);
		if ($id !== NULL) {
			$this->db->where([$this->table . '.id' => $id]);
		}
		if (! $with_trashed && $this->soft_delete) {
			$this->db->where($this->table . '.deleted_at IS NULL');
		}
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	/**
	 * -------------------------
	 * CREATE METHOD
	 * (modified to be bound on context)
	 * -------------------------
	 */
	public function create($data)
	{
		return ($this->db->insert($this->table, $data)) ? $this->db->insert_id() : FALSE;
	}

	/**
	 * -------------------------
	 * UPDATE METHOD
	 * (modified to be bound on context)
	 * -------------------------
	 */
	public function update($data, $id = NULL)
	{
		if ($id) {
			return $this->db->update($this->table, $data, [$this->table . '.id' => $id]);
		} else {
			return $this->db->update($this->table, $data);
		}
	}

	/**
	 * -------------------------
	 * DELETE METHOD
	 * -------------------------
	 */
	public function delete($id = NULL)
	{
		$data = $this->get($id);
		if ($data) {
			if ($this->soft_delete && $this->db->field_exists('deleted_at', $this->table)) {
				$delete_data = [ $this->table . '.deleted_at' => date('Y-m-d H:i:s') ];
				db_timestamp('deleted', $delete_data, $this->session_user->id, $this->session_user->type);
				return $this->db->update($this->table, $delete_data, [$this->table . '.id' => $data->id]);
			} else {
				return $this->db->delete($this->table, [$this->table . '.id' => $data->id]);
			}
		} else {
			return FALSE;
		}
	}
}
