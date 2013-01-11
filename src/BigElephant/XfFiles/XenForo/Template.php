<?php namespace BigElephant\XfFiles\XenForo;

use BigElephant\XfTools\XenForo\Model;

class Template extends Model {

	public function getTemplates($styleId)
	{
		if ($styleId == -1)
		{
			return $this->getDb()->fetchAll('
				SELECT *, -1 AS style_id
				FROM xf_admin_template
			');
		}

		return $this->getDb()->fetchAll('
			SELECT *
			FROM xf_template
			WHERE style_id = ?
		', $styleId);
	}
}