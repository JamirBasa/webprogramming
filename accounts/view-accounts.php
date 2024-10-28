<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Accounts</h4>
            </div>
        </div>
    </div>
    <div class="modal-container"></div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <?php
                            require_once '../classes/account.class.php';
                            session_start();
                            $accountObj = new Account();
                        ?>
                        <div class="d-flex justify-content-center align-items-center">
                            <form class="d-flex me-2">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control form-control-light" id="custom-search" placeholder="Search accounts...">
                                    <span class="input-group-text bg-primary border-primary text-white brand-bg-color">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </form>
                            <div class="d-flex align-items-center">
                                <label for="role-filter" class="me-2">Role</label>
                                <select id="role-filter" class="form-select">
                                    <option value="choose">Choose...</option>
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
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="table-accounts" class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start">No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $array = $accountObj->showAll();

                                foreach ($array as $arr) {
                                ?>
                                    <tr>
                                        <td class="text-start"><?= $i ?></td>
                                        <td><?= $arr['first_name'] ?></td>
                                        <td><?= $arr['last_name'] ?></td>
                                        <td><?= $arr['username'] ?></td>
                                        <td><?= $arr['role'] ?></td>

                                        <td class="text-nowrap">
                                            <a href="../products/editproduct.php?id=<?= $arr['id'] ?>" class="btn btn-sm btn-outline-success me-1">Edit</a>
                                            <?php if (isset($_SESSION['account']['is_admin']) && $_SESSION['account']['is_admin']) { ?>
                                                <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="<?= $arr['id'] ?>" data-name="<?= htmlspecialchars($arr['username']) ?>">Delete</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
