<?php
/*
 * matches-submit.php
 * NerdieLuv match results page.
 * Receives the user's name via GET, validates input, looks up their
 * record in singles.txt, finds all compatible matches, and displays them.
 *
 * Extra Feature #1: Validates name is not blank and exists in file.
 * Extra Feature #2: Displays per-user photos from images/ directory.
 */
include("common.php");

/*
 * Checks whether two personality type strings share at least one
 * letter at the same index position.
 * $type1 - first 4-letter personality type (e.g. "ISTJ")
 * $type2 - second 4-letter personality type
 * Returns true if at least one letter matches at the same position.
 */
function personality_match($type1, $type2) {
    for ($i = 0; $i < 4; $i++) {
        if ($type1[$i] === $type2[$i]) {
            return true;
        }
    }
    return false;
}

/*
 * Determines whether two people are a valid match based on:
 * - opposite gender
 * - compatible ages (each within the other's seeking range)
 * - same favorite OS
 * - at least one shared personality letter at the same index
 * $user - associative array for the current user
 * $other - associative array for a potential match
 * Returns true if all four criteria are met.
 */
function is_match($user, $other) {
    /* Must be opposite gender */
    if ($user["gender"] === $other["gender"]) {
        return false;
    }

    /* Each person's age must be within the other's seeking range */
    if ($other["age"] < $user["min_age"] || $other["age"] > $user["max_age"]) {
        return false;
    }
    if ($user["age"] < $other["min_age"] || $user["age"] > $other["max_age"]) {
        return false;
    }

    /* Must share the same favorite OS */
    if ($user["os"] !== $other["os"]) {
        return false;
    }

    /* Must share at least one personality letter at the same index */
    if (!personality_match($user["type"], $other["type"])) {
        return false;
    }

    return true;
}

/*
 * Outputs the HTML for a single match result div.
 * $person - associative array with the matched person's data
 */
function display_match($person) {
    ?>
    <div class="match">
        <p>
            <img src="<?= get_user_image($person["name"], $person["gender"]) ?>"
                 alt="user photo" />
            <?= $person["name"] ?>
        </p>
        <ul>
            <li><strong>gender:</strong> <?= $person["gender"] ?></li>
            <li><strong>age:</strong> <?= $person["age"] ?></li>
            <li><strong>type:</strong> <?= $person["type"] ?></li>
            <li><strong>OS:</strong> <?= $person["os"] ?></li>
        </ul>
    </div>
    <?php
}

/* Read the name from the GET parameter and find the user's record */
$name = isset($_GET["name"]) ? $_GET["name"] : "";

generate_header("NerdieLuv - Matches for $name");

/* Validate: name must not be blank */
if (!preg_match('/^.+$/', $name)) {
    show_error("You submitted an empty name.");
}

/* Validate: user must exist in the file */
$user = find_single($name);
if ($user === null) {
    show_error("User \"$name\" was not found in the system.");
}

$singles = get_all_singles();
?>

        <h3>Matches for <?= $name ?></h3>

<?php
/* Loop through all singles and display each match */
foreach ($singles as $other) {
    if ($other["name"] !== $name && is_match($user, $other)) {
        display_match($other);
    }
}
?>

<?php generate_footer(); ?>