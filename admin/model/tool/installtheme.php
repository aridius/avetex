<?php
class ModelToolInstalltheme extends Model {
	public function restore($sql) {
	foreach (explode(";\n", $sql) as $sql) {
			$sql = trim($sql);

			if ($sql) {
				$sql_prefix = str_replace("PREFIX_DB_", DB_PREFIX, $sql);
				$this->db->query($sql_prefix);
			}
		}

		$this->cache->delete('*');
	}

}