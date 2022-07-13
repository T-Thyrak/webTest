<?php
    session_start();

    require_once "../../vendor/autoload.php";

    require_once "../controller/connect.php";

    require_once "../translations/translations.php";
    require_once "../translations/translations_handler.php";

    require_once "../controller/helper.php";

    use Envms\FluentPDO\Query;

    $pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $fluent = new Query($pdo);

    $GLOBALS['f'] = $fluent;

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = array_key_exists($_GET['lang'], $translation_array) ? $_GET['lang'] : 'en';
    } else {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'en';
        }
    }
    $GLOBALS['tr'] = get_translation_handler($_SESSION['lang']);
    
    if(!isset($_COOKIE['php-l4-token'])){
        header("Location: ../index.php");  
    }

    $token = $_COOKIE['php-l4-token'];

    //array or boolean of token_query
    $token_query = $fluent->from('tokens')
                    ->select('user_id')
                    ->where('token', $token)
                    ->fetch();
    
    if($token_query === false){
        header("Location: ../index.php");  
    }

    $user_id = $token_query['user_id'];

    $product_query = $fluent -> from('products')
                             -> select('id , name, amount, price')
                             -> where('user_id', $user_id)
                             ->fetchAll();

    $GLOBALS['product_query'] = $product_query;

    $fluent->update('tokens')
        ->set('last_updated', date('Y-m-d H:i:s', time() + 3600 * 5))
        ->where('token', $token)
        ->execute();

    setcookie('php-l4-token', $token, time() + 3600 * 5, '/');

    $GLOBALS['user_id'] = $user_id;
?>

<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/light.png">

    <link rel="stylesheet" href="../resources/css/common.css">
    <link rel="stylesheet" href="../resources/css/main.css">
    <title>Product Page</title>

    <script class="init">
        $(document).ready(() => { $('#example').DataTable(
            {
                language: {
                    "emptyTable": "<?php echo $GLOBALS['tr']->get('dt.empty_table'); ?>",
                    "info": "<?php echo $GLOBALS['tr']->get('dt.info'); ?>",
                    "infoEmpty": "<?php echo $GLOBALS['tr']->get('dt.info_empty'); ?>",
                    "infoFiltered": "<?php echo $GLOBALS['tr']->get('dt.info_filtered'); ?>",
                    "thousands": "<?php echo $GLOBALS['tr']->get('dt.thousands'); ?>",
                    "lengthMenu": "<?php echo $GLOBALS['tr']->get('dt.length_menu'); ?>",
                    "loadingRecords": "<?php echo $GLOBALS['tr']->get('dt.loading_records'); ?>",
                    "processing": "<?php echo $GLOBALS['tr']->get('dt.processing'); ?>",
                    "search": "<?php echo $GLOBALS['tr']->get('dt.search'); ?>",
                    "zeroRecords": "<?php echo $GLOBALS['tr']->get('dt.zero_records'); ?>",
                    "paginate": {
                        "first": "<?php echo $GLOBALS['tr']->get('dt.paginate.first'); ?>",
                        "last": "<?php echo $GLOBALS['tr']->get('dt.paginate.last'); ?>",
                        "next": "<?php echo $GLOBALS['tr']->get('dt.paginate.next'); ?>",
                        "previous": "<?php echo $GLOBALS['tr']->get('dt.paginate.previous'); ?>"
                    },
                    "aria": {
                        "sortAscending": "<?php echo $GLOBALS['tr']->get('dt.aria.sort_ascending'); ?>",
                        "sortDescending": "<?php echo $GLOBALS['tr']->get('dt.aria.sort_descending'); ?>"
                    }
                }
            }
        ); });
    </script>
</head><body>
    <div class="c-navbar">

        <div class="c-y-padding">
            <div class="c-x-padding">
                <!-- navbar project logo, left align -->
                <div class="c-navbar-inner">
                    <div class="c-lalign">
                        <a href="../index.php">
                            <img src="../assets/img/revert.png" alt="logo" class="c-logo" width="32">
                        </a>
                        <!-- project name -->
                        <h4>Web Application Lab</h4>
                    </div>
                    <!-- navbar menu, right align -->
                    <div class="c-ralign">
                        <!-- navbar items (Add product and a dropdown settings) -->
                        <div class="c-nav-item">
                            <button onclick="toggleAddProduct(<?php echo $GLOBALS['user_id'] ?>)" class="btn bg-white">
                                <i class="bi bi-node-plus"></i>
                                <?php echo $GLOBALS['tr']->get('add_products') ?>
                            </button>
                        </div>
                        <div class="c-nav-item">
                            <div class="change-language">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="changeLangMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo $GLOBALS['tr']->get("change_language") ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="changeLangMenuButton">
                                        <a href="main_page.php?lang=en" class="dropdown-item">English</a>
                                        <a href="main_page.php?lang=eo" class="dropdown-item">Esperanto</a>
                                        <a href="main_page.php?lang=zh-ht" class="dropdown-item">繁體中文</a>
                                        <a href="main_page.php?lang=jp" class="dropdown-item">日本語</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="c-nav-item">
                            <div class="settings">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="settingsButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill"></i>
                                        <?php echo $GLOBALS['tr']->get('settings') ?>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="settingsButton">
                                        <li><a href="logout.php" class="dropdown-item"><?php echo $GLOBALS['tr']->get('logout') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="c-child">
        <div class="mx-auto w-75 p-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo $GLOBALS['tr']->get('th.product_id') ?></th>
                        <th><?php echo $GLOBALS['tr']->get('th.product_name') ?></th>
                        <th><?php echo $GLOBALS['tr']->get('th.product_quantity') ?></th>
                        <th><?php echo $GLOBALS['tr']->get('th.product_price') ?></th>
                        <th><?php echo $GLOBALS['tr']->get('th.actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $prod = $GLOBALS['product_query'];
                        $i = 0;
                        foreach ($prod as $row) {
                            $price = sprintf("%.2f", $row['price']/100);
                            $row_encode = json_encode($row);
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['amount']."</td>";
                            echo "<td>$".$price."</td>";
                            echo "<td><button onclick='toggleEdit($row_encode)' id='btn-edit' class='btn btn-primary'><i class='bi bi-pencil-square'></i>&nbsp;&nbsp;".$GLOBALS['tr']->get('th.actions.edit')."</button>&nbsp;&nbsp;<button onclick='toggleDelete($row_encode)' id='btn-delete' class='btn btn-danger'><i class='bi bi-trash'></i>&nbsp;&nbsp;".$GLOBALS['tr']->get('th.actions.delete')."</td>";
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<script>
    async function toggleEdit(row){
        var product_id = row.id;
        var product_name = row.name;
        var product_qty = row.amount;
        var product_price = row.price;

        const { value: formValues } = await Swal.fire({
            title: <?php echo "'".$GLOBALS['tr']->get('swal.edit.title')."'" ?>,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: <?php echo "'".$GLOBALS['tr']->get('swal.edit.confirm')."'" ?>,
            denyButtonText: <?php echo "'".$GLOBALS['tr']->get('swal.edit.discard')."'" ?>,
            cancelButtonText: <?php echo "'".$GLOBALS['tr']->get('swal.edit.cancel')."'" ?>,
            width: '700px',
            html:
                '<table class="w-100">'+
                '<tr>'+
                '<td class="text-left">'+'<label for="id"><?php echo $GLOBALS['tr']->get('th.product_id') ?> :</label>'+ '</td>'+
                '<td>'+`<input id="pd_id" class="swal2-input" name="id" value=${product_id} disabled>` +'</td>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+ '<label for="product_name"><?php echo $GLOBALS['tr']->get('th.product_name') ?> :</label>'+'</td>'+
                '<td>'+`<input id="pd_name" class="swal2-input" name="product_name" value=${product_name}>`+'</td>'+
                '</tr>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+ '<label for="product_qty"><?php echo $GLOBALS['tr']->get('th.product_quantity') ?> :</label>'+'</td>'+
                '<td>'+`<input id="pd_qty" class="swal2-input" name="product_qty" value=${product_qty}>` +'</td>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+'<label for="product_price"><?php echo $GLOBALS['tr']->get('th.product_price') ?> :</label>' +'</td>'+
                '<td>'+ `<input id="pd_price" class="swal2-input" name="product_price" value=${product_price/100}>`+'</td>'+
                '</tr>'+
                '</table>',
            focusConfirm: false,
            preConfirm: () => {
                return {
                    pd_id: document.getElementById('pd_id').value,
                    pd_name: document.getElementById('pd_name').value,
                    pd_qty: document.getElementById('pd_qty').value,
                    pd_price: document.getElementById('pd_price').value * 100,
                }
            }
            });
            /* Read more about isConfirmed, isDenied below */
            if (formValues) {
                onlyNumberQty = checkOnlyNumber(formValues.pd_qty);
                qty = parseFloat(formValues.pd_qty);
                price = Math.round(formValues.pd_price);

                if(!isValidName(formValues.pd_name) || !isValidPrice(formValues.pd_price) || !isValidQty(qty) || !onlyNumberQty){
                    Swal.fire(
                        '<?php echo $GLOBALS["tr"]->get("swal.edit.confirm.error.title") ?>',
                        '<?php echo $GLOBALS["tr"]->get("swal.edit.confirm.error.text") ?>',
                        'error'
                    );
                }else{
                    Swal.fire({
                        icon: 'question',
                        title: '<?php echo $GLOBALS['tr']->get("swal.edit.confirm.title") ?>',
                        showDenyButton: true,
                        confirmButtonText: '<?php echo $GLOBALS['tr']->get("swal.edit.confirm.save") ?>',
                        denyButtonText: "<?php echo $GLOBALS['tr']->get("swal.edit.confirm.cancel") ?>",
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            modifyDataInDatabase({
                                pd_id: formValues.pd_id,
                                pd_name : formValues.pd_name,
                                pd_qty : qty,
                                pd_price: price
                            });
                            Swal.fire('<?php echo $GLOBALS['tr']->get("swal.edit.confirm.save.title") ?>', '', 'success').then((result) => {
                                    window.location.href = "./main_page.php";
                                }
                            );
                            
                        } else if (result.isDenied) {
                            Swal.fire('<?php echo $GLOBALS['tr']->get("swal.edit.confirm.cancel.title") ?>', '', 'info')
                        }
                    });
                }
            
                
                // Swal.fire('Saved!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('<?php echo $GLOBALS['tr']->get("swal.edit.confirm.cancel.title") ?>', '', 'info')
            }
    }

    function modifyDataInDatabase(row){
        var resp = {};
        let setting = {
            url : "http://localhost:<?php echo $_ENV['LOCALHOST_PORT'] ?>/src/views/modify_data.php",
            method: "POST",
            timeout: 0,
            headers: {
                'Content-Type': "application/json",
            },
            async: false,
            success: response => {
                resp = response.status;
            },
            data: JSON.stringify(row),
        };
        $.ajax(setting);
        return resp;
    }

    function isValidName(name){
        name = name.trim();
        if(name.length == 0){
            return false;
        }

        if(name.length >= 200){
            return false;
        }
        return true;
    }
    function isValidQty(qty){
        if(Number.isInteger(qty)){
            return true;
        }
        return false;
    }
    function isValidPrice(price){
        if(typeof(price) != 'number'){
            return false;
        }
        return true;
    }
    function checkOnlyNumber(qty) {
        return /^\-?[0-9]+(e[0-9]+)?(\.[0-9]+)?$/.test(qty);
    }
    function toggleDelete(row){
        var product_id = row.id;
        Swal.fire({
        title: '<?php echo $GLOBALS['tr']->get('swal.delete.title') ?>',
        text: "<?php echo $GLOBALS['tr']->get('swal.delete.text') ?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<?php echo $GLOBALS['tr']->get('swal.delete.confirm') ?>',
        cancelButtonText: '<?php echo $GLOBALS['tr']->get('swal.delete.cancel') ?>',
        }).then((result) => {
        if (result.isConfirmed) {
            deleteDataFromDataBase({
                product_id
            });

            Swal.fire(
            '<?php echo $GLOBALS['tr']->get('swal.delete.confirm.title') ?>',
            '<?php echo $GLOBALS['tr']->get('swal.delete.confirm.text') ?>',
            'success'
            ).then((result) => {
                    window.location.href = "./main_page.php";
                }
            );
        }
     })
    }
    function deleteDataFromDataBase(product_id){
        var resp = {};
        let setting = {
            url : "http://localhost:<?php echo $_ENV['LOCALHOST_PORT'] ?>/src/views/delete_data.php",
            method: "POST",
            timeout: 0,
            headers: {
                'Content-Type': "application/json",
            },
            async: false,
            success: response => {
                resp = response.status;
            },
            data: JSON.stringify({
                pd_id: product_id,
            }),
        };
        $.ajax(setting);
        return resp;
    }
    async function toggleAddProduct(user_id) {
        const { value: formValues } = await Swal.fire({
            title: '<?php echo $GLOBALS['tr']->get('swal.add.title') ?>',
            html: `
            <table class="w-100">
            <tr>
            <td class="text-left"><label for="user_id"><?php echo $GLOBALS['tr']->get('th.user_id') ?> :</label></td>
            <td><input id="add_user_id" class="swal2-input" name="user_id" value=${user_id} readonly></td>
            </tr>
            <tr>
            <td class="text-left"><label for="product_name"><?php echo $GLOBALS['tr']->get('th.product_name') ?> :</label></td>
            <td><input id="add_product_name" class="swal2-input" name="product_name" value=""></td>
            </tr>
            <tr>
            <td class="text-left"><label for="product_qty"><?php echo $GLOBALS['tr']->get('th.product_quantity') ?> :</label></td>
            <td><input id="add_product_qty" class="swal2-input" name="product_qty" value=""></td>
            </tr>
            <tr>
            <td class="text-left"><label for="product_price"><?php echo $GLOBALS['tr']->get('th.product_price') ?> :</label></td>
            <td><input id="add_product_price" class="swal2-input" name="product_price" value=""></td>
            </tr>
            </table>`,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?php echo $GLOBALS['tr']->get('swal.add.confirm') ?>',
            cancelButtonText: '<?php echo $GLOBALS['tr']->get('swal.add.cancel') ?>',
            showLoaderOnConfirm: true,
            width: '700px',
            focusConfirm: false,
            preConfirm: () => {
                return {
                    user_id: user_id,
                    product_name: document.getElementById('add_product_name').value,
                    product_qty: document.getElementById('add_product_qty').value,
                    product_price: document.getElementById('add_product_price').value,
                };
            }
        });

        if (formValues) {
            let nameValidity = isValidName(formValues.product_name);
            let qtyContainsOnlyNumber = checkOnlyNumber(formValues.product_qty);
            let qty = parseFloat(formValues.product_qty);
            let qtyValidity = isValidQty(qty);
            let priceContainsOnlyNumber = checkOnlyNumber(formValues.product_price);
            let price = parseFloat(formValues.product_price);
            let priceValidity = isValidPrice(price);
            
            if (!nameValidity || !qtyValidity || !priceValidity || !qtyContainsOnlyNumber || !priceContainsOnlyNumber) {
                Swal.fire('<?php echo $GLOBALS['tr']->get('swal.add.confirm.error.title') ?>', "<?php echo $GLOBALS['tr']->get('swal.add.confirm.error.text') ?>", 'error');
                return;
            } else {
                Swal.fire({
                    title: '<?php echo $GLOBALS['tr']->get('swal.add.confirm.title') ?>',
                    html: `
                    <p>User ID : ${formValues.user_id}</p>
                    <p>Product name : ${formValues.product_name}</p>
                    <p>Product qty: ${qty}</p>
                    <p>Product price : ${price}</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo $GLOBALS['tr']->get('swal.add.confirm.save') ?>',
                    cancelButtonText: '<?php echo $GLOBALS['tr']->get('swal.add.confirm.cancel') ?>',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let realPrice = Math.round(price * 100);

                        let resp = addDataToDatabase({
                            user_id: formValues.user_id,
                            product_name: formValues.product_name,
                            product_qty: qty,
                            product_price: realPrice,
                        });

                        if (resp == 200) {
                            Swal.fire(
                                '<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.success.title') ?>',
                                '<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.success.text') ?>',
                                'success'
                            ).then((result) => {
                                    window.location.href = "./main_page.php";
                                }
                            );
                        } else if (resp == 403) {
                            Swal.fire('<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.forbidden.title') ?>', "<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.forbidden.text') ?>", 'error');
                        } else {
                            Swal.fire('<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.error.title') ?>', "<?php echo $GLOBALS['tr']->get('swal.add.confirm.save.error.text') ?>", 'error');
                        }
                    } else {
                        Swal.fire('<?php echo $GLOBALS['tr']->get('swal.add.confirm.cancel.title') ?>', "<?php echo $GLOBALS['tr']->get('swal.add.confirm.cancel.text') ?>", 'info');
                    }
                });
            }
        } else {
            Swal.fire('<?php echo $GLOBALS['tr']->get('swal.add.confirm.cancel.title') ?>', "<?php echo $GLOBALS['tr']->get('swal.add.confirm.cancel.text') ?>", 'info');
        }
    }

    function addDataToDatabase(data) {
        var resp = {};

        let settings = {
            url: "http://localhost:<?php echo $_ENV['LOCALHOST_PORT'] ?>/src/views/add_data.php",
            method: "POST",
            timeout: 0,
            headers: {
                'Content-Type': "application/json",
            },
            async: false,
            success: response => {
                resp = response.status;
            },
            data: JSON.stringify({
                u_id: data.user_id,
                pd_name: data.product_name,
                pd_qty: data.product_qty,
                pd_price: data.product_price,
            }),
        };

        $.ajax(settings);

        return resp;
    }
</script>


</html>