<?php

class Report{

    public $start_date;
    public $end_date;

    public $connection;
    public $user_in_session;

    public function __construct($connection, $user_in_session)
    {
        $this->connection = $connection;
        $this->user_in_session = $user_in_session;
    }

    public function fetch_track_price_report($start_date, $end_date) {
        $this->start_date = strtotime($start_date);
        $this->end_date = strtotime($end_date);

        $entities = array();

        if(empty($this->start_date) || empty($this->end_date)) {
            echo "date fields cannot be null!";
        }
        else {
            $sql = "SELECT * FROM product_entity_features WHERE item_entity_set_by='$this->user_in_session'";
            $result = mysqli_query($this->connection, $sql);
            $num_rows_count = mysqli_num_rows($result);

            if ($num_rows_count > 0) {
                while ($rows = mysqli_fetch_assoc($result)) { 
                    if (strtotime(date('Y-m-d', strtotime($rows['created_at']))) >= $this->start_date AND strtotime(date('Y-m-d', strtotime($rows['updated_at']))) <= $this->end_date) {
                        array_push($entities, $rows);
                    } 
                }
            }
        }

        if (count($entities) > 0) {
            echo json_encode($entities);
        } 
        else {
            echo "report is null";
        }
    }
}



