<?php

/**
 *
 * @author ser
 */
interface Config {
    /**
     * Adds a new column to the DataGrid.
     */
    public function addColumn(string $key, Column $column): Config;

    /**
     * Returns all columns for the given DataGrid.
     */
    public function getColumns(): array;
}


class DefaultConfig implements Config {
    
    
    private $columnsArray; //Holds all column properties of the DataGrid
    
    function __construct() {
        $this->columnsArray= array();
    }
    
    public function addColumn(string $key, Column $column): Config{
        
    }

    public function getColumns(): array{
        
        return $this->columnsArray;
      
    }
    
    public function addIntColumn(): Config {
        $type = new DataType('NumberType', 'Integer');
        
        $column = (new Column)
            ->withLabel(func_get_arg(0)) 
            ->withDataType($type) 
            ->withAlign('default');
        
        $this->columnsArray[$column->getLabel()] = $column->getColumnPropertyArray();
        
        return $this;
    }
    
    public function addTextColumn(): Config {
        $type = new DataType('TextType');
        
        $column = (new Column)
            ->withLabel(func_get_arg(0)) 
            ->withDataType($type) 
            ->withAlign('default');

        $this->columnsArray[$column->getLabel()] = $column->getColumnPropertyArray();
        
        return $this;
    }
    
    public function addCurrencyColumn(): Config {
        $args= func_get_args();
        $args[0]='MoneyType';
        $type = new DataType($args);
        //var_dump($args);
        
        $column = (new Column)
            ->withLabel(func_get_arg(0)) 
            ->withDataType($type) 
            ->withAlign('default');

        $this->columnsArray[$column->getLabel()] = $column->getColumnPropertyArray();
        
        return $this;
    }
    
}