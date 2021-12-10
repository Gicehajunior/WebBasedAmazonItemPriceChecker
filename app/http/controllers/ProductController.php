
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
            $sql = "SELECT * FROM product_entity_features WHERE item_link='$this->product_link' AND item_price='$this->product_current_price' AND id='$this->user_in_session'";
            $result = mysqli_query($this->connection, $sql);
            $num_rows_count = mysqli_num_rows($result);

            if ($num_rows_count < 0) {
                $sql = "INSERT INTO product_entity_features (item_link, item_price, status, item_entity_set_by, created_at, updated_at) VALUES ('$this->product_link', '$this->product_current_price', '0', '$this->user_in_session', '$this->created_at', '$this->updated_at')";
                $result = mysqli_query($this->connection, $sql);

                if ($result) {
                    echo "item entity save success!";
                } else {
                    echo "item entity save failed!";
                }
            } else {
                $DB_Query = "UPDATE product_entity_features SET item_link='" . $this->product_link . "', item_price='" . $this->product_current_price . "', updated_at='" . $this->updated_at . "' WHERE item_entity_set_by='" . $this->user_in_session . "'";
                $Exec = mysqli_query($this->connection, $DB_Query);

                if ($Exec) {
                    echo "item entity save success!";
                } else {
                    echo "item entity save failed!";
                }
            }
        } else {
            echo "All fields should not be null!";
        }
    }
}


