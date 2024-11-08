<?php
session_start();

if (isset($_SESSION['account'])) {
    if (!$_SESSION['account']['is_staff']) {
        header('location: login.php');
    }
} else {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        /* Styling for the search results */
        p.search {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>

<body>

    <?php
    require_once '../classes/account.class.php';

    $accountObj = new Account();

    $keyword = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize input from the search form
        $keyword = htmlentities($_POST['keyword']);
    }

    $array = $accountObj->showAll($keyword);
    ?>

    <form action="" method="post">
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="">All</option>
            <?php
            $roleList = $accountObj->fetchAccount();
            foreach ($roleList as $rol) {
            ?>
                <option value="<?= $rol['role'] ?>"><?= $rol['role'] ?></option>
            <?php
            }
            ?>
        </select>
        <label for="keyword">Search</label>
        <input type="text" name="keyword" id="keyword" value="<?= $keyword ?>">
        <input type="submit" value="Search" name="search" id="search">
    </form>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>First_name</th>
            <th>Last_name</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php
        $i = 1;
        if (empty($array)) {
        ?>
            <tr>
                <td colspan="7">
                    <p class="search">No account found.</p>
                </td>
            </tr>
        <?php
        }
        foreach ($array as $arr) {
        ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $arr['first_name'] ?></td>
                <td><?= $arr['last_name'] ?></td>
                <td><?= $arr['username'] ?></td>
                <td><?= $arr['role'] ?></td>
                <td>
                    <a href="editproduct.php?id=<?= $arr['id'] ?>">Edit</a>
                    <?php
                    if ($_SESSION['account']['is_admin']) {
                    ?>
                        <a href="#" class="deleteBtn" data-id="<?= $arr['id'] ?>" data-name="<?= $arr['username'] ?>">Delete</a>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
            $i++;
        }
        ?>
    </table>

    <script src="./accounts.js"></script>
</body>

</html>