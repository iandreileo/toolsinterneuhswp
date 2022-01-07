<?php

add_shortcode("register_shortcode", "register_shortcode");

function register_shortcode() {
    
global $current_user;
wp_get_current_user();

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$company = $_POST['company'];
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];

if (($firstname != '') && ($lastname != '') && ($password != '') && ($email != '') && ($username != '')) {

    // Cream userul
    $user_id = wp_create_user($username, $password, $email);

    // Daca nu e creat bine, afisam eroarea
    if (!$user_id || is_wp_error($user_id)) {
        // TODO: Display an error message and don't proceed.
        print_r($user_id->errors);
    } else {
        $userinfo = array(
        'ID' => $user_id,
        'first_name' => $firstname,
        'last_name' => $lastname,
    );
    
        // Update the WordPress User object with first and last name.
        wp_update_user($userinfo);
    
        // Add the company as user metadata
        update_usermeta($user_id, 'company', $company);
        
        // Redirect to login
        echo "Contul a fost creat cu succes! <a href='#'>Click aici</a> pentru a te autentifica.";    
        
    }
    
} else {
    echo "Nu ai completat toate campurile necesare!";
}

if (is_user_logged_in()) : ?>

    <p>You're already logged in and have no need to create a user profile.</p>
    
<?php else : ?>

    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        <div class="username">
            <label for="username">Username *</label>
            <input name="username"
                    id="username"
                    value="<?php echo esc_attr($username) ?>">
        </div>
        <div class="firstname">
            <label for="firstname">Prenume *</label>
            <input name="firstname"
                    id="firstname"
                    value="<?php echo esc_attr($firstname) ?>">
        </div>
        <div class="lastname">
            <label for="lastname">Nume *</label>
            <input name="lastname"
                    id="lastname"
                    value="<?php echo esc_attr($lastname) ?>">
        </div>
        <div class="email">
            <label for="email">Email *</label>
            <input name="email"
                    id="email"
                    type="email"
                    value="<?php echo esc_attr($email) ?>">
        </div>
        <div class="password">
            <label for="password">Parola *</label>
            <input name="password"
                    id="password"
                    type="password"
                    value="<?php echo esc_attr($password) ?>">
        </div>   
            <!--<div class="company">-->
            <!--<label for="company">Companie:</label>-->
            <!--<input name="company"-->
            <!--        id="company"-->
            <!--        value="<?php echo esc_attr($company) ?>">-->
            <!--</div>-->
            <input type="submit" value="INREGISTRARE">
    </form>
    
<?php endif; 
}




?>
