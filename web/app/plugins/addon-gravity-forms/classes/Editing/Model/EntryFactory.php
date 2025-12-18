<?php

namespace ACA\GravityForms\Editing\Model;

use ACA\GravityForms\Column;
use ACA\GravityForms\Editing;
use ACA\GravityForms\Field\Field;
use ACA\GravityForms\Field\Type;
use ACP;

class EntryFactory {

	/**
	 * @return ACP\Editing\Model
	 */

	/**
	 * @param Column\Entry $column
	 * @param string       $field_id
	 * @param Field        $field
	 *
	 * @return ACP\Editing\Model
	 */
	public function create( Column\Entry $column, $field_id, Field $field ) {
		switch ( true ) {
			case $field instanceof Type\ProductSelect:
				return new Editing\Model\Entry\Select( $column, $field_id, $field, $field->get_options() );

			case $field instanceof Type\Date:
				return new Editing\Model\Entry\Date( $column, $field_id, $field );

			case $field instanceof Type\CheckboxGroup:
				return new Editing\Model\Entry\Checkbox( $column, $field_id, $field, $field->get_options() );

			case $field instanceof Type\Checkbox:
				return new Editing\Model\Entry\Check( $column, $field_id, $field, $field->get_value() );

			case $field instanceof Type\Select:
				return $field->is_multiple()
					? new Editing\Model\Entry\Multiselect( $column, $field_id, $field, $field->get_options() )
					: new Editing\Model\Entry\Select( $column, $field_id, $field, $field->get_options() );

			case $field instanceof Type\Radio:
				return new Editing\Model\Entry\Select( $column, $field_id, $field, $field->get_options() );

			case $field instanceof Type\Input:
				return $field instanceof Type\Number
					? new Editing\Model\Entry\Number( $column, $field_id, $field )
					: new Editing\Model\Entry\Input( $column, $field_id, $field, $field->get_input_type() );

			default:
				return new ACP\Editing\Model\Disabled( $column );
		}
	}

}