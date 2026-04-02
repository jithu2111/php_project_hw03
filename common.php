<?php
/*
 * common.php
 * Contains shared functions used across all NerdieLuv pages.
 * Provides header and footer output to reduce redundancy.
 */

/*
 * Outputs the common HTML head, opening body tag, and the
 * NerdieLuv logo/banner section used on every page.
 * $title - the text for the <title> element
 */
function generate_header($title) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="nerdieluv.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="container">
        <div id="logo">
            <h1>
                <span>nerd</span><span class="luv">Luv</span><sup>tm</sup>
            </h1>
            <p>where meek geeks meet</p>
        </div>
    <?php
}

/*
 * Outputs the common footer section shown on every page,
 * including the site description, copyright, back link,
 * and W3C validator images.
 */
function generate_footer() {
    ?>
        <div id="footer">
            <p>
                This page is for single nerds to meet and date each other! Type in
                your personal information and wait for the nerdly luv to begin!
                Thank you for using our site.
            </p>
            <p>Results and page (C) Copyright NerdLuv Inc.</p>
            <p>
                <a href="index.php">
                    <img src="back.png" alt="back" />
                    Back to front page
                </a>
            </p>
        </div>
        </div> <!-- end #container -->
    </body>
    </html>
    <?php
}

/*
 * Displays an error page with the given message, outputs the footer,
 * and exits the script. Used for validation errors.
 * $message - the error description to display
 */
function show_error($message) {
    ?>
        <div class="error">
            <h2>Error! Invalid data.</h2>
            <p>We're sorry. <?= $message ?>
               Please go back and try again.</p>
        </div>
    <?php
    generate_footer();
    exit;
}

/*
 * Reads the singles.txt file and returns an array of associative arrays.
 * Each element has keys: name, gender, age, type, os, min_age, max_age.
 */
function get_all_singles() {
    $singles = [];
    $lines = file("singles.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode(",", $line);
        $singles[] = [
            "name"    => $parts[0],
            "gender"  => $parts[1],
            "age"     => (int) $parts[2],
            "type"    => $parts[3],
            "os"      => $parts[4],
            "min_age" => (int) $parts[5],
            "max_age" => (int) $parts[6]
        ];
    }
    return $singles;
}

/*
 * Finds the record for a specific user by name.
 * Returns the associative array for that user, or null if not found.
 * $name - the name to search for
 */
function find_single($name) {
    $singles = get_all_singles();
    foreach ($singles as $person) {
        if ($person["name"] === $name) {
            return $person;
        }
    }
    return null;
}

/*
 * Returns the image path for a given user.
 * Checks for a personal photo in images/ first, then falls back
 * to a gender-specific default (male.png or female.png).
 * $name - the user's display name
 * $gender - "M" or "F"
 */
function get_user_image($name, $gender) {
    $filename = strtolower(str_replace(" ", "_", $name)) . ".jpg";
    $local_path = "images/" . $filename;
    if (file_exists($local_path)) {
        return $local_path;
    }
    if ($gender === "M") {
        return "male.png";
    }
    return "female.png";
}
?>
