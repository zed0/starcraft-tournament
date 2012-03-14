<?php

include 'common.php';

setcookie ($cookie_name, "", time() - 3600);
unset($login);

include 'header.php';

?>
		<h2>Logout</h2>
		<p>Successfully logged out</p>
<?php

include 'footer.php';
