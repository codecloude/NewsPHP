<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои заявки</title>
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
        <br><br><br>
        <p class="fs-2 text-center">Мои заявки</p>
        
        <div class="row row-cols-1 row-cols-md-3 g-4">   
            <?php

                session_start();
                $_SESSION['vkidd']=$_GET['uid'];
                $_SESSION['vkname']=$_GET['first_name'];
                $_SESSION['vkfam']=$_GET['last_name'];

                $uid = 0;
                if(isset($_GET["uid"])){
                    $uid = $_GET["uid"];
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
                WHERE users.UserID = $uid";
                
                if($result = $conn->query($sql)){

                    if ($result->num_rows){
                        foreach($result as $row){
                        echo "<div class=\"col\">";
                        echo "<div class=\"card h-100\">";
                        echo "<img class=\"hot_news-image\" src=\"" . $row['Img'] ."\"/>";
                        echo "<div class=\"card-body\">";
                        echo "<h3 class=\"hot_news-title\"> ". $row['Title']  ."</h3>";
                        echo "<p class=\"hot_news-preview-text\">". $row['Description']  ."</p>";
                        echo "<p class=\"hot_news-preview-text\">Автор: ". $row['UserName']  ."</p>";
                        echo "<p class=\"hot_news-preview-text\">Категория: ".$row['CatName']."</p>";
                        echo "<p class=\"hot_news-preview-text\">Дата: ". $row['Date']  ."</p>";
                        echo "<p class=\"hot_news-preview-text\">Статус: " . $row['StatName'] . "</p>";
                        if ($_COOKIE['userRole'] == 2) {
                            echo "<p class=\"hot_news-preview-text\">
                                <a href='http://mysite1bckup/editord.php?order=". $row['OrdID']  ."'>Редактировать</a></p>";
                            echo "<p class=\"hot_news-preview-text\">
                                <a href='http://mysite1bckup/delreq.php?order=". $row['OrdID']  ."'>Удалить заявку</a></p>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        }
                    } else {
                        echo "<h5 class=\"card-title\">А тут ничего нет</h5>";
                    }
                
                    $result->free();
                } else{
                    echo "Ошибка: " . $conn->error;
                }
            ?> 
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