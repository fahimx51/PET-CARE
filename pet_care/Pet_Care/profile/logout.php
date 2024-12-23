<?php
session_start();
if (isset($_SESSION['email'])){
    session_unset();
    session_destroy();
    echo "<script> location.href = '../home/index.php' </script>";
}
else{
    echo "<script>alert('Do not access from URL!!!')</script>";
    echo "<script> location.href = '../home/index.php'</script>";
}
?>