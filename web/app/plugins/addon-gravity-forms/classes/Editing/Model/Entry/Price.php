<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Editing;

class Price extends Editing\Model\Entry {

	public function get_view_settings() {
		$data = parent::get_view_settings();

		$data['type'] = 'number';
		$data['range_step'] = '0.01';

		return $data;
	}

}