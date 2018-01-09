# Backend of ecology management system

## Installation

```
    請點右邊綠色 Clone or Download 並下載為zip使用
    前端開發請下載後另外git至前端repo (避免多組共用程式碼污染)
```

```
開發基於 https://github.com/TMineCola/bookPrj
```

```
1. 先匯入ecology.sql到資料庫
2. 把dbConnectExample.php重新命名成dbConnect.php，並且鍵入相關資訊（如sql id、password、db_table's name）
3. 把文件移至webserver root document目錄下，如：
- xampp -> htdocs
- linux下，自行安裝webserver則為 /var/www/html (預設，如無修改)
```

## 前端
```
主要以bootstrap為核心，此github內View檔皆以簡單開發，以利測試為主，後續採用需自行編輯美化。
```
- 主要進行 View 的建置, 並利用GET、POST Method針對Controller進行操作或直接呼叫Function中的函式獲得資料


## 後端

- 主要進行 Control邏輯 及 Module與DB溝通, 提供前端所需要的資料
- 模組有
1. 資料建檔（新增、編輯、刪除）
2. 照片上傳且讀取exif存入DB（新增、編輯、刪除）

# ***** 如果發現有錯誤 *****
# *** 煩請告知或開issues ***