<?php  
session_start();

$koneksi= mysqli_connect('localhost','root','','kasir');

if(isset($_POST['login'])){
//initial variable
$username = $_POST['username'];
$password = $_POST['password'];

$check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'AND password = '$password'");
$hitung = mysqli_num_rows($check);

if($hitung>0){
    //jika datanya ada, dan ditemukan
    //berhasil login 
    $_SESSION['login'] = true;
    header('location: login.php/index.php');

} else {
    //Datanya tidak ada 
    //gagal login 
    echo '
    <script>
    alert("username atau passwor salah")
    window.location.href="login.php"
    </script>';
}
}

?>