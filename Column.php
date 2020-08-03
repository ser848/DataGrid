<?php

/**
 *
 * @author ser
 */
interface iColumn
{
    /**
     * Changes the column title that will be shown as the header.
     */
    public function withLabel(string $label): Column;

    public function getLabel(): string;

    /**
     * Sets the data type for a column.
     */
    public function withDataType(DataType $type): Column;

    public function getDataType(): DataType;

    /**
     * Set the alignment of the content in the column.
     */
    public function withAlign(string $align): Column;

    public function getAlign(): string;
}

class Column implements iColumn {
    
    private $label;
    private $type;
    private $align;
    
    private $columnPropertyArray;


    public function withLabel(string $label): Column {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string {
        return $this->label;
    }

    public function withDataType(DataType $type): Column {
        $this->type = $type;
        return $this;
    }

    public function getDataType(): DataType {
        return $this->type;
    }

    public function withAlign(string $align): Column {
        $this->align = $align;
        return $this;
    }

    public function getAlign(): string {
        return $this->align;
    }
    
    public function getColumnPropertyArray(): array {
        $this->columnPropertyArray = array(
            "label"=>$this->label, 
            "type"=>$this->type, 
            "align"=>$this->align);
        return $this->columnPropertyArray;
    }
    
}