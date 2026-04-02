<?php
/*
 * signup.php
 * NerdieLuv new user signup page.
 * Displays a form for new users to enter their profile information.
 * Submits data via POST to signup-submit.php.
 */
include("common.php");
generate_header("NerdieLuv - Sign Up");
?>

        <fieldset>
            <legend>New User Signup:</legend>

            <form action="signup-submit.php" method="post"
                  enctype="multipart/form-data">
                <p>
                    <strong>Name:</strong>
                    <input type="text" name="name" size="16" maxlength="16" />
                </p>

                <p>
                    <strong>Gender:</strong>
                    <label>
                        <input type="radio" name="gender" value="M" />
                        Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="F"
                               checked="checked" />
                        Female
                    </label>
                </p>

                <p>
                    <strong>Age:</strong>
                    <input type="text" name="age" size="6" maxlength="2" />
                </p>

                <p>
                    <strong>Personality type:</strong>
                    <input type="text" name="type" size="6" maxlength="4" />
                    (<a href="http://www.humanmetrics.com/cgi-win/JTypes2.asp">Don't
                    know your type?</a>)
                </p>

                <p>
                    <strong>Favorite OS:</strong>
                    <select name="os">
                        <option>Windows</option>
                        <option>Mac OS X</option>
                        <option>Linux</option>
                    </select>
                </p>

                <p>
                    <strong>Seeking age:</strong>
                    <input type="text" name="min_age" size="6" maxlength="2"
                           placeholder="min" />
                    to
                    <input type="text" name="max_age" size="6" maxlength="2"
                           placeholder="max" />
                </p>

                <p>
                    <strong>Photo:</strong>
                    <input type="file" name="photo" />
                </p>

                <p>
                    <input type="submit" value="Sign Up" />
                </p>
            </form>
        </fieldset>

<?php generate_footer(); ?>