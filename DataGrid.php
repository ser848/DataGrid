<?php

/**
 *
 * @author ser
 */
interface DataGrid {
    /**
     * Changes the current configuration of the DataGrid.
     */
    public function withConfig(Config $config): DataGrid;

    /**
     * Renders the code to the screen that is to display the prepared DataGrid.
     * As a parameter it accepts: all available data and the current state of the DataGrid in the form of an object - State.
     * Based on State, the method is to sort the lines and divide them into pages.
     */
    public function render(array $rows, State $state): string;
}

class HtmlDataGrid implements DataGrid {
    
    private $dataGrid; //The array with the formatted dataGrid
    private $config;
    private $dataGridHeader; //The header row of the dataGrid
    
    public function withConfig(Config $config): DataGrid {
        $this->config = $config;
        
        foreach($config->getColumns() as $headerData){
            
            $this->dataGridHeader[$headerData[label]] = NULL;
            
        }
        //echo '<pre>'; print_r($this->dataGridHeader); echo '</pre>';    
        return $this;
    }
    
    public function render(array $rows, State $state): string {
        
        //Creation of the dataGrid array
        foreach($rows as $inputRow){
            
            $dataGridRow = $this->dataGridHeader;
                        
            foreach($this->dataGridHeader as $key => $data) {
                
                $dataGridRow[$key] = $this->config->getColumns()[$key]['type']
                        ->format($inputRow[$key]);
                
            }
            
            $this->dataGrid[] = $dataGridRow;
        }
       
        $pages = ceil(sizeof($this->dataGrid)/$state->getRowsPerPage());
        $currentPage = $state->getCurrentPage();
        if ($currentPage > $pages) {
            $currentPage = $pages;
        }
        $rowsPerPage = $state->getRowsPerPage();
        
        $startRow = ($rowsPerPage * ($currentPage-1));
        
        //The dataGridSlice array holds the rows of the dataGrid that are to 
        //be displayed according to the Pagination menu and the $state object
        $dataGridSlice = array_slice($this->dataGrid, $startRow, $rowsPerPage);
        
        $htmlDataGrid = '<table class="table table-bordered"> <thead> <tr>';
        
        foreach ($this->dataGridHeader as $key=>$data) {
            $htmlDataGrid .= '<th>' . $key . '</th>';
        }
        
        $htmlDataGrid .= '</tr> </thead>';
        
        $htmlDataGrid .= '<tbody> <tr>';
        
        foreach ($dataGridSlice as $dataGridRow) {
            $htmlDataGrid .= '<tr>';
            foreach ($dataGridRow as $data) {
                $htmlDataGrid .= '<td style=\'text-align: right;\'>' . $data . '</td>';
            }
            $htmlDataGrid .= '</tr>';
        }
        $htmlDataGrid .= '</tbody> </table>';
        
        //Pagination HTML output
        $htmlPagination = '<ul class="pagination justify-content-center">';
     
        for ($x = 0; $x <= $pages+1; $x++) {
            $htmlPagination .= '<li class="page-item';
            if (($x == 0 && $currentPage == 1) || ($x == $pages+1 && $currentPage == $pages)) {
                $htmlPagination .= ' disabled';
            }
            elseif ($x == $currentPage) {
                $htmlPagination .= ' active';
            }
            
            $htmlPagination .= '"><a class="page-link" href="';
            $htmlPagination .= 'http://localhost/DataGrid/?page=';
            if ($x==0) {
                $htmlPagination .= $currentPage-1;
            }
            elseif ($x==$pages+1) {
                $htmlPagination .= $currentPage+1;
            }
            else {
                $htmlPagination .= $x;
            }
            
            $htmlPagination .= '&rows=';
            $htmlPagination .= $rowsPerPage;
            $htmlPagination .= '&orderby=balance&order=desc';
            $htmlPagination .= '">';
            
            if ($x==0) {
                $htmlPagination .= 'Previous';
            }
            elseif ($x==$pages+1) {
                $htmlPagination .= 'Next';
            }
            else {
                $htmlPagination .= $x;
            }
            
            $htmlPagination .= '</a></li>';
            
        } 
        
        $htmlPagination .= '</ul>';
        
        
        return $htmlDataGrid.$htmlPagination;
        
    }
    
}