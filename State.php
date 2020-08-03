<?php

/**
 *
 * @author ser
 */
interface State {
    /**
     * Returns the current DataGrid page to be displayed
     */
    public function getCurrentPage(): int;

    /**
     * The key of the column on which the DataGrid will be sorted.
     */
    public function getOrderBy(): string;

    /**
     * Should the data be sorted in descending order?
     */
    public function isOrderDesc(): bool;

    /**
     * Should the data be sorted in ascending order?
     */
    public function isOrderAsc(): bool;

    /**
     * Returns the number of lines to be displayed on one page.
     */
    public function getRowsPerPage(): int;
}

class HttpState implements State {
    
    private $page;
    private $orderBy;
    private $order;
    private $rowsPerPage;
    
    private $orderByOptions = array('id', 'name', 'age', 'company', 'balance', 'phone', 'email');
    private $defaultPage=1;
    private $defaultOrderBy='id';
    private $defaultOrder='desc';
    private $defaultRowsPerPage=9;
    
    function __construct() {
        $this->page=htmlspecialchars($_GET["page"]);
                
        $this->orderBy=htmlspecialchars($_GET["orderby"]);
        
        $this->order=htmlspecialchars($_GET["order"]);
        
        $this->rowsPerPage=htmlspecialchars($_GET["rows"]);
        
        return $this;
    }
    
    public function create(): self {
        
        $state = new self();
        
        return $state;
       
    }
    
        public function getCurrentPage(): int {
        
        if (ctype_digit($this->page)&&$this->page>0) {
            return $this->page;
        }
        else {
            return $this->defaultPage;
        }
            
    }

    public function getOrderBy(): string {
        $this->orderBy=strtolower($this->orderBy);
        if(in_array($this->orderBy, $this->orderByOptions)){
            return $this->orderBy;
        }
        else {
            return $this->defaultOrderBy;
        }
    }

    public function isOrderDesc(): bool {
        $this->order=strtolower($this->order);
        if ($this->order=='desc') {
            return true;
        }
        elseif ($this->order=='asc'){
            return $this->orderDesc=false;
        }
        else {
            if ($this->defaultOrder=='desc') {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function isOrderAsc(): bool {
        $this->order=strtolower($this->order);
        if ($this->order=='asc') {
            return true;
        }
        elseif ($this->order=='desc'){
            return $this->orderDesc=false;
        }
        else {
            if ($this->defaultOrder=='desc') {
                return false;
            }
            else {
                return true;
            }
        }
    }
    
    public function getRowsPerPage(): int {
        if (ctype_digit($this->rowsPerPage)&&$this->rowsPerPage>0&&$this->rowsPerPage<9) {
            return $this->rowsPerPage;
        }
        else {
            return $this->defaultRowsPerPage;
        }
    }
    
}