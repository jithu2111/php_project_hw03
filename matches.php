<?php
/*
 * matches.php
 * NerdieLuv returning user page.
 * Displays a form for existing users to enter their name
 * and view their dating matches. Submits via GET to matches-submit.php.
 */
include("common.php");
generate_header("NerdieLuv - View Matches");
?>

        <fieldset>
            <legend>Returning User:</legend>

            <form action="matches-submit.php" method="get">
                <p>
                    <strong>Name:</strong>
                    <input type="text" name="name" size="16" maxlength="16" />
                </p>

                <p>
                    <input type="submit" value="View My Matches" />
                </p>
            </form>
        </fieldset>

<?php generate_footer(); ?>