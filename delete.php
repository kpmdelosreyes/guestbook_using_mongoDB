<?php

class My_mongo {
    public $mongo = "";
    public $db = "";
    public $coll = "";
    function __construct(){
        $this->mongo = new Mongo();   
        $this->db = $this->mongo->selectDB("board_db");   
        $this->coll = $this->db->selectCollection("board_tb");
       
    }    
    function deleteData($ids){
            $id = explode(",", $ids);
            foreach($id as $val_id){
                $conditions = array(
                    '_id' => new MongoId(trim($val_id))
                );   
                $this->coll->remove($conditions);
            }
          
    }
    
   
}
$my_mongo = new My_mongo();
$delete = $my_mongo->deleteData($_GET['ids']);
header("Location:index.php");
?>