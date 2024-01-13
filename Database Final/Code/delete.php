<?php
include 'inc_con.php';
$id = $_GET['ids'];
$delete = "DELETE FROM user WHERE id = $id";
$deletequery = mysqli_query($conn, $delete);
if($deletequery){
    ?>
<script>
    window.location.replace("admins.php");
</script>

<?php 

}else{
    echo 'Not deleted';
}

?>