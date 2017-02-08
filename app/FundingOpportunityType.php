<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingOpportunityType extends Model
{
    /**
     * Build HTML dropdown string for the Funding Opportunity types that exist.
     * Depends on "bootstrap-select.min.js"
     *
     * @return string
     */
    public static function getDropdownHTMLList(){
        $html = '<select class="fundingType custom-select" name="fundingType" id="fundingType">'.PHP_EOL;
        //$html .= '<option disabled selected value> -- select an option -- </option>';
        $types = self::orderBy('name', 'asc')->get();
        foreach($types as $type ){
           $html .= '<option value="'.$type->id.'">'.$type->name.'</option>'.PHP_EOL;
        }
        $html .=  "</select>".PHP_EOL;
        return $html;
    }
}
