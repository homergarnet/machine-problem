<?php

?>
<input id="user-id" type="hidden" value="<?php if(isset($_SESSION["loginuser"])){ echo $_SESSION["loginuser"];}else{ echo "0";}?>"/>