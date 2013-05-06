<?php
class Testwell_passage_model extends CI_Model {
	/**
	 * Return number of passages in the reading
	 * comprehension section of the test by looking up
	 * the metadata table for sections. We store this
	 * in the custom field for READING_COMP section.
	 * Return number
	 * of passages upon success and -1 on failure
	 *
	 * @return	integer
	 */
	function get_num_passages() {
		$in_table=TWELL_SECT_META_TBL;
		$this->db->where('sectionName','READING_COMP');
		$this->db->select('sectionCustom');
		$query=$this->db->get($in_table);
		if ($query->num_rows() == 1) {
			$row = $query->row();
			return (int)($row->sectionCustom);
		} else {
			$this->firephp->log("Num passages query failed! Problem");
			return -1;
		}
	}
}