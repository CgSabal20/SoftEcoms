<?php 

session_start();

include_once("../config/config.php");
include_once("changelogController.php");




if(isset($_POST['logout'])){


    $admin_id = $_SESSION['user_id'];

    
 
    addAdminLog(

        $admin_id,

        'LOGOUT',

        'Admin logged out of the system'

    );



    unset($_SESSION['authUser']);
    unset($_SESSION['user_id']);
    unset($_SESSION['userRole']);

    session_destroy();


   
    header("Location: /E-commerce/public/index");
    exit(0);

}





if(isset($_POST['updateOrderStatus'])){

    $order_id = $_POST['order_id'];

    $status = strtolower($_POST['status']);



   
    $allowed = ['pending', 'completed', 'cancelled'];



    if(in_array($status, $allowed)){



  
        $stmt = $conn->prepare("

        UPDATE orders

        SET status = ?

        WHERE id = ?

        ");

        $stmt->bind_param("si", $status, $order_id);

        $stmt->execute();




        $orderQuery = mysqli_query($conn, "

        SELECT COnumber

        FROM orders

        WHERE id='$order_id'

        ");

        $orderData = mysqli_fetch_assoc($orderQuery);

        $COnumber = $orderData['COnumber'];




        $admin_id = $_SESSION['user_id'];




      
        addAdminLog(

            $admin_id,

            'ORDER_UPDATE',

            "Changed order $COnumber status to $status"

        );

    }



    header("Location: ../../public/admin/orders.php");
    exit();

}

?>