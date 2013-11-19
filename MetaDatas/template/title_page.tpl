<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja"><!-- "ja" added -->
<head>
<link href="stylesheet.css" type="text/css" rel="stylesheet" />
<title>タイトルページ</title>
</head>
<body>
  <h1 style="margin-top: 5em"><%$novel_title%></h1>
  <h4><%$novel_sub_title%></h4>

  <h3 style="margin-top: 3em"><%$author|smarty:nodefaults%></h3>
  <h3 style="margin-top: 3em"><%$composer|smarty:nodefaults%></h3>

  <h4>制作 <%$smarty.now|date_format:"%Y年%m月%d日"%></h4>
</body>
</html>
