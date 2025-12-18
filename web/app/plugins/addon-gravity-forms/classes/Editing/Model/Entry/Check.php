<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Column;
use ACA\GravityForms\Editing;
use ACA\GravityForms\Field\Field;

class Check extends Editing\Model\Entry {

	/**
	 * @var string
	 */
	private $value;

	public function __construct( Column\Entry $column, $field_id, Field $field, $value ) {
		parent::__construct( $column, $field_id, $field );

		$this->value = (string) $value;
	}

	public function get_view_settings() {
		$options = [ '', $this->value ];

		return [
			'type'    => 'togglable',
			'options' => array_combine( $options, $options ),
		];
	}

}