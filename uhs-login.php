<?php

// Functia de redirect
function redirect_login_page()
{
    // Modifica aici cu pagina pe care e loginu
    $login_page = home_url("/login/");
    $page_viewed = basename($_SERVER["REQUEST_URI"]);

    if ($page_viewed == "wp-login.php" && $_SERVER["REQUEST_METHOD"] == "GET") {
        wp_redirect($login_page);
        exit();
    }
}
add_action("init", "redirect_login_page");

// Returnam failed in pagina de login
function login_failed()
{
    // Modifica aici cu pagina pe care e loginu
    $login_page = home_url("/login/");
    wp_redirect($login_page . "?login=failed");
    exit();
}
add_action("wp_login_failed", "login_failed");

function verify_username_password($user, $username, $password)
{
    // Modifica aici cu pagina pe care e loginu
    $login_page = home_url("/login/");
    if ($username == "" || $password == "") {
        wp_redirect($login_page . "?login=empty");
        exit();
    }
}
add_filter("authenticate", "verify_username_password", 1, 3);

// Shortcodeul pentru formularul de login
function login_shortcode()
{
    $login = isset($_GET["login"]) ? $_GET["login"] : 0;
    if ($login === "failed") {
        echo '<p class="login-msg"><strong>ERROR:</strong> Invalid username and/or password.</p>';
    } elseif ($login === "empty") {
        echo '<p class="login-msg"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
    } elseif ($login === "false") {
        echo '<p class="login-msg"><strong>ERROR:</strong> You are logged out.</p>';
    }

    global $current_user;
    wp_get_current_user();

    if (!is_user_logged_in()) {
        $args = [
            "echo" => true,
            "redirect" => "/",
            "form_id" => "loginform",
            "label_username" => __("Username"),
            "label_password" => __("Password"),
            "label_remember" => __("Remember Me"),
            "label_log_in" => __("Log In"),
            "id_username" => "user_login",
            "id_password" => "user_pass",
            "id_remember" => "rememberme",
            "id_submit" => "wp-submit",
            "remember" => true,
            "value_username" => null,
            "value_remember" => false,
        ];

        wp_login_form($args);
    } else {
        // Redirect
    }
}

add_shortcode("login_shortcode", "login_shortcode");

?>
