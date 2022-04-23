<?php

// Revision History:
// Developer     STUDENT-ID Date       COMMENTS
// Aafrin Sayani (2030150) 2022-04-18 Cpmpleted all classes and collections.

 
class collection
{
    public $items = array();
    
    public function add($primary_key, $item)
    {
        $this->items[$primary_key] = $item;
    }
    
    public function remove($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            unset($this->items[$primary_key]);
        }
    }
    
    public function get($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            return($this->items[$primary_key]);
        }
  
    }
      
    public function count()
    {
        return count($this->items);
    }
}
