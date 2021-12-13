
<?php

class Product {
    public $product_link;
    public $product_current_price;

    public $connection;
    public $user_in_session;
    public $created_at;
    public $updated_at;

    public function __construct($connection, $product_link, $product_current_price)
    {
        $this->connection = $connection; 
        $this->product_link = $product_link;
        $this->product_current_price = $product_current_price;
        $this->created_at = $this->updated_at = date("Y-m-d H:i:s");
    }

    public function set_item_entities($user_in_session) {
        $this->user_in_session = $user_in_session;

        if (!empty($this->product_link || !empty($this->product_current_price))) { 
            $DB_Query = "UPDATE product_entity_features SET active='0', updated_at='" . $this->updated_at . "' WHERE item_entity_set_by='" . $this->user_in_session . "' AND active='1'";
            $Exec = mysqli_query($this->connection, $DB_Query);

            if ($Exec) {
                $sql = "INSERT INTO product_entity_features (item_link, item_price, status, item_entity_set_by, active, created_at, updated_at) VALUES ('$this->product_link', '$this->product_current_price', '0', '$this->user_in_session', '1', '$this->created_at', '$this->updated_at')";
                $result = mysqli_query($this->connection, $sql);

                if ($result) {
                    echo "item entity save success!";
                } else {
                    echo "item entity save failed!";
                }
            } else {
                echo "item entity save failed!";
            } 
        } else {
            echo "All fields should not be null!";
        }
    }
}


