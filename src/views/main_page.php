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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/light.png">

    <style>
        * {
            font-family: Comfortaa, sans-serif;
        }
    </style>
    <title>Product Page</title>

    <script class="init"> $(document).ready(() => { $('#example').DataTable(); }); </script>
</head><body>
    <div class="mx-auto w-75 p-3">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Edit</th>
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
                        echo "<td><button onclick='toggleEdit($row_encode)' id='btn-edit' class='btn btn-primary'><i class='bi bi-pencil-square'></i>&nbsp;&nbsp;Edit</button>&nbsp;&nbsp;<button onclick='toggleDelete($row_encode)' id='btn-delete' class='btn btn-danger'><i class='bi bi-trash'></i>&nbsp;&nbsp;Delete</td>";
                        $i++;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>

<script>
    async function toggleEdit(row){
        product_id = row.id;
        product_name = row.name;
        product_qty = row.amount;
        product_price = row.price;

        const { value: formValues } = await Swal.fire({
            title: 'Edit the row',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            denyButtonText: `Discard`,
            width: '700px',
            html:
                '<table class="w-100">'+
                '<tr>'+
                '<td class="text-left">'+'<label for="id">Product id :</label>'+ '</td>'+
                '<td>'+`<input id="pd_id" class="swal2-input" name="id" value=${product_id} disabled>` +'</td>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+ '<label for="product_name">Product name :</label>'+'</td>'+
                '<td>'+`<input id="pd_name" class="swal2-input" name="product_name" value=${product_name}>`+'</td>'+
                '</tr>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+ '<label for="product_qty">Product qty :</label>'+'</td>'+
                '<td>'+`<input id="pd_qty" class="swal2-input" name="product_qty" value=${product_qty}>` +'</td>'+
                '</tr>'+
                '<tr>'+
                '<td class="text-right">'+'<label for="product_price">Product price :</label>' +'</td>'+
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
                        'Deny Change',
                        'Some input changed may cause error! Please try again.',
                        'error'
                    );
                }else{
                    Swal.fire({
                        icon: 'question',
                        title: 'Are you sure you want to Save the change?',
                        showDenyButton: true,
                        confirmButtonText: 'Save',
                        denyButtonText: `Don't save`,
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            modifyDataInDatabase({
                                pd_id: formValues.pd_id,
                                pd_name : formValues.pd_name,
                                pd_qty : qty,
                                pd_price: price
                            });
                            Swal.fire('Saved!', '', 'success').then((result) => {
                                    window.location.href = "./main_page.php";
                                }
                            );
                            
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info')
                        }
                    });
                }
            
                
                // Swal.fire('Saved!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
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
                console.log(response);
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
    function toggleDelete(){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            deleteDataFromDataBase({
                product_id
            });

            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
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
                console.log(response);
            },
            data: JSON.stringify({
                pd_id: product_id,
            }),
        };
        $.ajax(setting);
        return resp;
    }
</script>


</html>