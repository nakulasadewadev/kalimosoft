<?php header("Access-Control-Allow-Origin: '*'"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>kalimosoft</title>
    <?php include "top.php"; ?>
</head>

<body class="sidebar-dark">
    <?php if ($page == 'notfound') { ?>
        <div class="main-wrapper">
            <?php include $page . ".php"; ?>
        </div>
    <?php } else { ?>
        <div class="main-wrapper">
            <nav class="sidebar">
                <?php include "page/navigation.php"; ?>
            </nav>
            <div class="page-wrapper">
                <nav class="navbar">
                    <a href="#" class="sidebar-toggler">
                        <i data-feather="menu"></i>
                    </a>
                    <div class="navbar-content">
                        <ul class="navbar-nav">
                            <?php include "head.php"; ?>
                        </ul>
                    </div>
                </nav>
                <div class="page-content">
                    <?php include $page . ".php"; ?>
                </div>
            </div>
        </div>
    <?php } ?>

</body>

</html>