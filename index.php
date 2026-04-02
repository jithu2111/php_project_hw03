<?php
/*
 * index.php
 * NerdieLuv front page.
 * Displays the site logo, welcome message, and links to
 * the signup and matches pages.
 */
include("common.php");
generate_header("NerdieLuv");
?>

        <h2>Welcome!</h2>

        <div id="welcome">
            <ul>
                <li>
                    <img src="notepad.png" alt="notepad" />
                    <a href="signup.php">Sign up for a new account</a>
                </li>
                <li>
                    <img src="heart.png" alt="heart" />
                    <a href="matches.php">Check your matches</a>
                </li>
            </ul>
        </div>

<?php generate_footer(); ?>