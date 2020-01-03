<?php
//somewhere set a value
$valuse = "a value";
?>

<script>
// then echo it into the js/html stream
// and assign to a js variable
var spge = '<?php echo $valuse ;?>';

// then
alert(spge);

</script>