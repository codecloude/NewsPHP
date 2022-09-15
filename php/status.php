<form action="statedit_sc.php" method="post" enctype="multipart/form-data">
    <select name="status" size="2">
        <?php
            $conn = new mysqli("localhost", "root", "", "amogus");
            $sql = "SELECT * FROM statreq ";
            $conn->query($sql);
            if ($result = $conn->query($sql)) {
                $rowsCount = $result->num_rows; // количество полученных строк
                // echo "Получили {$rowsCount} строк";
                if ($rowsCount > 0) {
                    foreach ($result as $row) {
                        echo "<option value=". $row['StatID'] .">". $row['StatName'] ."</option>";
                        $StatID = $row['StatID'];
                    }   
                } else {
                    echo "Ошибка: " . $conn->error;
                }
            } else {
                echo "Ошибка: " . $conn->error;
            }
            $conn->close();
            
        ?>
    </select>
    <button type="submit">Сохранить</button>
</form>
