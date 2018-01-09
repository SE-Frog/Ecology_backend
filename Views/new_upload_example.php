<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>單一及多檔案上傳</title>
</head>
<body>
    <form action="../Control/photoControl.php" method="post" enctype="multipart/form-data">
        <input type="text" name="directory">
        <!-- 使用 html 5 實現單一上傳框可多選檔案方式，須新增 multiple 元素 -->
        <input type="file" name="myFile[]" id="" accept="image/jpeg,image/jpg,image/gif,image/png" multiple>

        <input type="submit" value="上傳檔案">
    </form>
</body>
</html>