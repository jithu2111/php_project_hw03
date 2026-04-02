<?php
/*
 * signup-submit.php
 * NerdieLuv signup form handler.
 * Receives POST data from signup.php, validates all fields using
 * regular expressions, creates a new record line, and appends it
 * to singles.txt. Displays a thank-you message on success.
 *
 * Extra Feature #1: Robust form validation with regex.
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
 * Validates all signup form fields using regular expressions.
 * Checks for blank name, valid age, valid gender, valid personality
 * type, valid OS, valid seeking ages, and duplicate users.
 * Calls show_error and exits if any check fails.
 * $data - associative array of submitted form fields
 */
function validate_signup($data) {
    /* Name must not be blank */
    if (!preg_match('/^.+$/', $data["name"])) {
        show_error("You submitted an empty name.");
    }

    /* Gender must be M or F */
    if (!preg_match('/^[MF]$/', $data["gender"])) {
        show_error("You submitted an invalid gender.");
    }

    /* Age must be an integer between 0 and 99 */
    if (!preg_match('/^\d{1,2}$/', $data["age"])) {
        show_error("You submitted an invalid age.");
    }

    /* Personality type must be 4 letters from Keirsey dimensions */
    if (!preg_match('/^[IE][NS][FT][JP]$/i', $data["type"])) {
        show_error("You submitted an invalid personality type.");
    }

    /* OS must be one of the three valid choices */
    if (!preg_match('/^(Windows|Mac OS X|Linux)$/', $data["os"])) {
        show_error("You submitted an invalid operating system.");
    }

    /* Min seeking age must be integer 0-99 */
    if (!preg_match('/^\d{1,2}$/', $data["min_age"])) {
        show_error("You submitted an invalid minimum seeking age.");
    }

    /* Max seeking age must be integer 0-99 */
    if (!preg_match('/^\d{1,2}$/', $data["max_age"])) {
        show_error("You submitted an invalid maximum seeking age.");
    }

    /* Min must be <= max */
    if ((int) $data["min_age"] > (int) $data["max_age"]) {
        show_error("Minimum seeking age cannot be greater than maximum.");
    }

    /* User must not already exist in the file */
    if (find_single($data["name"]) !== null) {
        show_error("User \"{$data['name']}\" is already in the system.");
    }
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
            strtoupper($data["type"]) . "," .
            $data["os"] . "," .
            $data["min_age"] . "," .
            $data["max_age"] . "\n";
    file_put_contents("singles.txt", $line, FILE_APPEND);
}

/* Read and validate the submitted form data */
$user = get_signup_data();

generate_header("NerdieLuv - Sign Up");
validate_signup($user);

/* Validation passed — save user and show success */
save_user($user);
?>

        <div class="success">
            <h2>Thank you!</h2>
            <p>Welcome to NerdLuv, <?= $user["name"] ?>!</p>
            <p>Now <a href="matches.php">log in to see your matches!</a></p>
        </div>

<?php generate_footer(); ?>