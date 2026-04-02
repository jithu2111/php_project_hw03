<?php
/*
 * signup-submit.php
 * NerdieLuv signup form handler.
 * Receives POST data from signup.php, creates a new record line,
 * and appends it to singles.txt. Displays a thank-you message.
 */
include("common.php");

/*
 * Reads the submitted POST data and returns an associative array
 * with the new user's profile information.
 */
function get_signup_data() {
    $data = [];
    $data["name"]    = $_POST["name"];
    $data["gender"]  = $_POST["gender"];
    $data["age"]     = $_POST["age"];
    $data["type"]    = $_POST["type"];
    $data["os"]      = $_POST["os"];
    $data["min_age"] = $_POST["min_age"];
    $data["max_age"] = $_POST["max_age"];
    return $data;
}

/*
 * Takes the user data array and appends a comma-separated line
 * to singles.txt in the required format.
 * $data - associative array of user profile fields
 */
function save_user($data) {
    $line = $data["name"] . "," .
            $data["gender"] . "," .
            $data["age"] . "," .
            $data["type"] . "," .
            $data["os"] . "," .
            $data["min_age"] . "," .
            $data["max_age"] . "\n";
    file_put_contents("singles.txt", $line, FILE_APPEND);
}

/* Process the submitted form data */
$user = get_signup_data();
save_user($user);

generate_header("NerdieLuv - Sign Up Successful");
?>

        <div class="success">
            <h2>Thank you!</h2>
            <p>Welcome to NerdLuv, <?= $user["name"] ?>!</p>
            <p>Now <a href="matches.php">log in to see your matches!</a></p>
        </div>

<?php generate_footer(); ?>