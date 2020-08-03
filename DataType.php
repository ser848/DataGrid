<?php

/**
 *
 * @author ser
 */
interface iDataType {
    /**
     * Formats the data for a given type.
     */
    public function format(string $value): string;
}

class DataType implements iDataType {
    
    private $dataTypeParam;
    
    public function format(string $value): string{
        
        if (in_array('NumberType', $this->dataTypeParam)) {
            if (in_array('Integer', $this->dataTypeParam)) {
    
                return $value;
            }
        }
        elseif (in_array('TextType', $this->dataTypeParam)) {
            return strip_tags($value);
        }
        elseif (in_array('MoneyType', $this->dataTypeParam)) {
            //An example of MoneyType that changes the number of decimals to 2
            $value = number_format($value, 2, ',', ' ');
            if (in_array('USD', $this->dataTypeParam)) {
                $value = $value.' USD';
            }
            return $value;
        }
        else {
            var_dump($this->dataTypeParam);
            return $value;
        }
        
    }
    
    function __construct() {
        $this->dataTypeParam= func_get_args();
        if (is_array($this->dataTypeParam[0])) {
            $this->dataTypeParam = $this->dataTypeParam[0]; 
        }
    }
    
    public function getDataTypeParam(): array {
        
        return $this->dataTypeParam;
    }
}