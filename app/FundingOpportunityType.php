<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundingOpportunityType extends Model
{
    /**
     * Build HTML dropdown string for the Funding Opportunity types that exist.
     * Depends on "bootstrap-select.min.js"
     *
     * This function is used in createOpportunity.blade.php
     * @return string
     */
    public static function getDropdownHTMLList(){
        $html = '<div class="form-group">
           <p> <label for="fundingType">Funding Type:</label></p>';

        $html .= '<select class="fundingType custom-select" name="fundingType" id="fundingType">'.PHP_EOL;
        $html .= '<option disabled selected value="-1"> -- select an option -- </option>';
        $types = self::orderBy('name', 'asc')->get();
        foreach($types as $type ){
           $html .= '<option value="'.$type->id.'">'.$type->name.'</option>'.PHP_EOL;
        }
        $html .=  "</select>
                    <small id=\"fundingTypeHelp\" class=\"form-text text-muted\">Don't see type?  <a href='".route('FundingOpportunityTypes.index')."'>Add it here. </a></small>
                    </div>
                    ".PHP_EOL;
        return $html;
    }
}
