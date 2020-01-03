<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<button onclick="goBack()">Go Back</button>

<p>Notice that clicking on the Back button here will not result in any action, because there is no previous URL in the history list.</p>

<script>
function goBack() {
    window.history.back();
}
</script>
</body>
</html>