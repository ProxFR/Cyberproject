<?php 
// Include the database configuration file  
require_once 'dbConfig.php'; 

// Get image data from database 
$result = $db->query("SELECT iv, user_profile_picture FROM users ORDER BY id DESC"); 
 
if ($result->num_rows > 0){ ?> 
    <div class="gallery"> 
        <?php while($row = $result->fetch_assoc()){ 

            $iv = hex2bin($row['iv']);
            $content = hex2bin($row['user_profile_picture']);

            $unencrypted_content = openssl_decrypt(
                $content,
                $cipher,
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );
            echo 'Content : ' .  base64_encode($unencrypted_content);
            ?>
             <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($unencrypted_content); ?>" /> 
        <?php } ?> 
    </div> 
<?php }else{ ?> 
    <p class="status error">Image(s) not found...</p> 
<?php } ?>