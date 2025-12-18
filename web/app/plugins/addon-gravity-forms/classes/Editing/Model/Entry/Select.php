<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Column;
use ACA\GravityForms\Editing;
use ACA\GravityForms\Field\Field;

class Select extends Editing\Model\Entry {

	/**
	 * @var array
	 */
	private $choices;

	public function __construct( Column\Entry $column, $field_id, Field $field, array $choices ) {
		parent::__construct( $column, $field_id, $field );

		$this->choices = $choices;
	}

	public function get_view_settings() {
		return array_merge( parent::get_view_settings(), [
			'type'    => 'select',
			'options' => $this->choices,
		] );
	}

}