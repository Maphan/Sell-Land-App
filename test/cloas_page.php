<!DOCTYPE html>
<html>
<body>

<button onclick="openWin()">Open w3schools.com in a new window</button>
<button onclick="closeWin()">Close the new window (w3schools.com)</button>

<script>
var myWindow=window;

function openWin() {
    myWindow = window.open("https://www.w3schools.com");
}

function closeWin() {
    myWindow.close();
}
//myWindow.close();
</script>

</body>
</html>