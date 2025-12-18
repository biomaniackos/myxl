<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Editing;
use ACA\GravityForms\Field;

class Number extends Editing\Model\Entry {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'number';

		if ( $this->field instanceof Field\Number ) {
			$data['range_min'] = $this->field->get_range_min();
			$data['range_max'] = $this->field->get_range_max();
		}

		return $data;
	}

}