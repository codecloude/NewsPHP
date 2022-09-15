<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <link rel="stylesheet" href="assets/css/mainpage_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg bg-light fixed-top shadow">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <!-- <!— <a class="navbar-brand" href="#">Hidden brand</a> —> -->
            <img src="assets/img/TODO.png" class="logo" alt="Logo">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="mainpage.php">Главная страница</a>
                </li>
            <?php if($_COOKIE['userRole']==3):?>
                <li class="nav-item">
                    <a href="isadmin.php" class="nav-link">Все заявки</a>
                </li>
            <?php else:?>
                <?php if(!isset($_COOKIE['user'])){
                    echo '<a href="auth.php" class="nav-link">Мои заявки</a>';
                    } else {
                        $conn = new mysqli("localhost", "root", "", "amogus");
                        if($conn->connect_error){
                            die("Ошибка: " . $conn->connect_error);
                        }
                        $sql = "SELECT UserID FROM users WHERE UserID=".$_COOKIE['id'];

                        if ($result = $conn->query($sql)) {
                                $rowsCount = $result->num_rows;
                                foreach ($result as $row) {
                                echo "<a class=\"nav-link\" href=\"http://mysite1bckup/myOrd.php?uid=". $row['UserID'] . "\">Мои заявки</a>";
                                echo "<a class=\"nav-link\" href=\"order.php\">Создать заявку</a>";
                            }
                            $result->free();
                        } else {
                            echo "Ошибка: " . $conn->error;
                        }
                    }
                ?>

            <?php endif;?>
            </ul>
            <form class="d-flex " role="search">
            <?php if(isset($_COOKIE['user'])):?>

            <button class="btn btn-sm btn-outline-secondary authorization-link " type="submit"><a href="php/exit.php" >Выйти</a></button>
            <?php else:?>
            <button class="btn btn-sm btn-outline-secondary authorization-link " type="submit"><a href="auth.php">Войти</a></button>
            <?php endif;?>
            </form>
            </div>
        </div>
    </nav>

</header>
        
<section class="hot_news">
    <div class="container">
        
        
        <div class="hot_news-list">   
            <?php
            $order = 0;
            if(isset($_GET["order"])){
                $order = $_GET["order"];
            }
            $conn = new mysqli("localhost", "root", "", "amogus");
            if($conn->connect_error){
                die("Ошибка: " . $conn->connect_error);
            }
            $sql = 
            "SELECT *
                -- news.Title, 
                -- news.Description, 
                -- news.Img, 
                -- news.CatID, 
                -- news.Date, 
                -- users.UserName,
                -- categories.CatName
            FROM 
                orders 
            JOIN users
                ON orders.User = users.UserID
            JOIN categories
                ON orders.CatID = categories.CatID
            JOIN statreq
                ON orders.StatusReq = statreq.StatID
            WHERE orders.OrdID = $order";
            
            session_start();
            $_SESSION['order'] = $order;

            if($result = $conn->query($sql)){
                
                foreach($result as $row){
                    echo "<div class=\"row\">";
                    echo "<div class=\"block col-sm-6 to_animate pt-5\">";


                    echo "<div class=\"col\">";
                    echo "<div class=\"card h-100 text-black bg-light mb-3 shadow-lg p-3 mb-5\">";
                    echo "<img class=\"card-img-top\" src=\"" . $row['Img'] ."\"/>";
                    
                    echo "<h3 class=\"hot_news-title\"> ". $row['Title']  ."</h3>";
                    echo "<p class=\"hot_news-preview-text\">". $row['Description']  ."</p>";
                    echo "<p class=\"hot_news-preview-text\">Автор: ". $row['UserName']  ."</p>";
                    echo "<p class=\"hot_news-preview-text\">Категория: ".$row['CatName']."</p>";
                    echo "<p class=\"hot_news-preview-text\">Дата: ". $row['Date']  ."</p>";
                    echo "<p class=\"hot_news-preview-text\">Статус: " . $row['StatName'] . "</p>";
                    
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";       
                }
                $result->free();
            } else{
                echo "Ошибка: " . $conn->error;
            }
            
            ?> 
            <div class="block col-sm-6 to_animate pt-5">
                <h3>Редактировать <strong>заявку</strong></h3>
                <form action="php/order_sc.php"  method="post" enctype="multipart/form-data">
                    <br><br><br>
                    <p class="contact-form-subject">
                        <label for="title" style="color:black">Тема <span class="required">*</span></label>
                        <input type="text" aria-required="true" size="30" value="" name="title" class="form-control" placeholder="Наименование проблемы">
                    </p>
                    <p class="contact-form-message">
                        <label for="disc" style="color:black">Описание проблемы</label>
                        <textarea aria-required="true" rows="8" cols="45" name="disc"  class="form-control" placeholder="Опишите проблему"></textarea>
                    </p>
                    <p class="nav-item dropdown ">
                        <label for="select" style="color:black" >Категории</label>
                        <?php
                            $conn = new mysqli("localhost", "root", "", "amogus");
                            $sql = "SELECT * FROM categories ";
                            $conn->query($sql);
                            if ($result = $conn->query($sql)) {
                                $rowsCount = $result->num_rows; // количество полученных строк
                                // echo "Получили {$rowsCount} строк";
                                if ($rowsCount > 0) {
                                    echo "<select class=\"form-control dropdown-toggle\" name=\"categories\" size=\".$rowsCount\">";
                                    foreach ($result as $row) {
                                        echo "<option value=" . $row['CatID'] . ">" . $row['CatName'] . " ";
                                        $CatID = $row['CatID'];
                                    }   
                                    echo "</select>";
                                } else {
                                echo "Категории не найдены";
                                }

                                $result->free();
                            } else {
                                echo "Ошибка: " . $conn->error;
                            }
                            $conn->close();
                        ?>
                    </p>
                    <p class="contact-form-submit vertical-margin-40">
                        <label for="image" style="color:black">Вставьте картинку*</label>
                        <br>
                        <input type="file" name="image">
                    </p>
                    <p class="contact-form-submit vertical-margin-40">
                        <button  class="btn btn-success" type="submit">Изменить</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<footer class="py-3 my-4 bckgr">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted"></a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted"></a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Портал нашего города</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted"></a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted"></a></li>
            </ul>
            <p class="text-center text-muted">© 2022 todobetter, Inc</p>
            
        </footer>

</body>
</html>