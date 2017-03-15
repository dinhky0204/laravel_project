<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 11/03/2017
 * Time: 14:00
 */
?>
Hi {{$name}},
<p>Please click the link to active account.</p>
{{route('confirmation',$token)}}
