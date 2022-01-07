<?php

add_shortcode("user_infos", "user_infos");
function user_infos()
{
    $user = wp_get_current_user();

    foreach ($user->data as $key => $user_data) {
        if (
            $key == "user_pass" ||
            $key == "user_activation_key" ||
            $key == "user_status"
        ) {
        } else {
            $nice_key = ucfirst(str_replace("_", " ", $key));

            if ($key == "user_registered") {
                $user_data = date_i18n(
                    get_option("date_format"),
                    strtotime($user_data)
                );
            }

            echo $nice_key . " : " . $user_data . "<br />";
        }
    }
    
    // Aici putem afisa custom field-uri din user
    $user = get_userdata($user->ID);
    // $user->test afiseaza customfieldu pentru test
    print_r($user->test);
}

?>
