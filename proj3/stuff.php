<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript">
function Search(){
    alert("search!");
    //search logic
    return false;
}
</script>
</head>
<body>
    <form onsubmit="return Search()">
        <input type="text" name="q" />
        <input type="submit" value="Search" />
    </form>
</body>
</html>