<?php
namespace App\Fixtures;

if (!class_exists('ACFMenuDepthLocation')) {
    class ACFMenuDepthLocation extends \ACF_Location
    {
        public function compare_advanced($value, $rule, $allow_all = false)
        {
            if ($allow_all && $value === 'all') {
                return true;
            }

            if ($rule['operator'] === '==') {
                return $value == $rule['value'];
            }

            if ($rule['operator'] === '!=') {
                return $value != $rule['value'];
            }

            if ($rule['operator'] === '<') {
                return $value < $rule['value'];
            }

            if ($rule['operator'] === '<=') {
                return $value <= $rule['value'];
            }

            if ($rule['operator'] === '>') {
                return $value > $rule['value'];
            }

            if ($rule['operator'] === '>=') {
                return $value >= $rule['value'];
            }

            if ($rule['operator'] === 'contains') {
                return stripos($value, $rule['value']) !== false;
            }

            if ($rule['operator'] === '!contains') {
                return stripos($value, $rule['value']) === false;
            }

            if ($rule['operator'] === 'starts') {
                return stripos($value, $rule['value']) === 0;
            }

            if ($rule['operator'] === '!starts') {
                return stripos($value, $rule['value']) !== 0;
            }

            /*if ($rule['operator'] === 'ends') {
                return acfe_ends_with($value, $rule['value']);
            }

            if ($rule['operator'] === '!ends') {
                return !acfe_ends_with($value, $rule['value']);
            }*/

            if ($rule['operator'] === 'regex') {
                return preg_match('/' . $rule['value'] . '/', $value);
            }

            if ($rule['operator'] === '!regex') {
                return !preg_match('/' . $rule['value'] . '/', $value);
            }

            if ($rule['operator'] === '=count') {
                return count($value) === (int) $rule['value'];
            }

            if ($rule['operator'] === '!=count') {
                return count($value) !== (int) $rule['value'];
            }

            if ($rule['operator'] === '>count') {
                return count($value) > $rule['value'];
            }

            if ($rule['operator'] === '>=count') {
                return count($value) >= $rule['value'];
            }

            if ($rule['operator'] === '<count') {
                return count($value) < $rule['value'];
            }

            if ($rule['operator'] === '<=count') {
                return count($value) <= $rule['value'];
            }

            return false;
        }

        public function initialize()
        {
            $this->name     = 'nav_menu_item_depth';
            $this->label    = __('Menu Item Depth', 'acf');
            $this->category = 'forms';
        }

        public function rule_values($choices, $rule)
        {
            if (!acf_is_screen('acf-field-group') && !acf_is_ajax('acf/field_group/render_location_rule')) {
                return [
                    $rule['value'] => $rule['value'],
                ];
            }

            ob_start();

            acf_render_field([
                'type' => 'number',
                'name' => 'value',
                'min' => 0,
                'prefix' => 'acf_field_group[location][' . $rule['group'] . '][' . $rule['id'] . ']',
                'value' => (isset($rule['value']) ? $rule['value'] : ''),
            ]);

            return ob_get_clean();
        }

        public function rule_operators($choices, $rule)
        {
            $choices['<']  = __('is less than', 'acf');
            $choices['<='] = __('is less or equal to', 'acf');
            $choices['>']  = __('is greater than', 'acf');
            $choices['>='] = __('is greater or equal to', 'acf');

            return $choices;
        }

        public function rule_match($result, $rule, $screen)
        {
            // Vars
            $depth = acf_maybe_get($screen, 'nav_menu_item_depth');

            // Bail early
            if (!$depth && $depth !== 0) {
                return false;
            }

            // Compare
            return $this->compare_advanced($depth, $rule);
        }
    }

    acf_register_location_type('\\App\\Fixtures\\ACFMenuDepthLocation');
}
