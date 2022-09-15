<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" href="assets/css/check.css">
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
<section class="contacts">
    <div class="container">
        <div class="container px-5 gx-5">    
            <form action="php/check_sc.php" method="post">
                <br><br><br>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label text-bg-light">Придумайте логин!</label>
                    <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label text-bg-light">Введите ваше имя!</label>
                    <input name="name" type="text" class="form-control" id="exampleCheck1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label text-bg-light">Придумайте пароль!</label>
                    <input name="pass" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                
                <button type="submit" class="form-text mt-2 text-center  btn btn-success">Зарегистрироваться</button>
            </form>
        </div>
        <!-- <form action="php/check_sc.php" class="contacts-form" method="post">
            <input name="login" type="text" placeholder="Введите ваш логин..." class="contacts-form-field">
            <input name="name" type="text" placeholder="Введите ваше имя..." class="contacts-form-field">
            <input name="pass" type="password" placeholder="Введите пароль..." class="contacts-form-field">



            <div class="welcome-link-row">
                <button class="welcome-link border" type="submit">Зарегистрироваться</button>
            </div>
        </form> -->
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