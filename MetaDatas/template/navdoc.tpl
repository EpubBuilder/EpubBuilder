<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<title>目次</title>
</head>
<body>

<!-- This file was generated with ncx2html.xslt created by kato kazuyuki downloaded from epubcafe -->
<!-- http://www.epubcafe.jp/download/ncx2html.xslt?attredirects=0&d=1 -->

<!-- The generated navdoc.html already contained: xmlns:epub="http://www.idpf.org/2011/epub" -->
<!-- added xmlns="http://www.w3.org/1999/xhtml" -->

<!-- changed xmlns:epub to xmlns:epub="http://www.ipdf.org/2007/ops" as directed by xxxx-san -->
<!-- however, epubcheck epub:type error persists. -->

<!-- Moved the xmlns:epub declaration to <nav> element as shown in: -->
<!-- hp12c - エラーメッセージから学ぶ電子書籍EPUB - 最初の一歩 -->
<!-- http://melborne.github.com/2012/11/12/epub-tutorial/ -->
<!-- This resolved epubcheck epub:type error. Thanks, hp12c. -->

<nav xmlns:epub="http://www.idpf.org/2007/ops" epub:type="toc">
<h1><%$novel_title%></h1>
<ol>
<%foreach from=$page_header item=item name=page_header key=key%>
<li>
<a href="<%$item.page_path%>"><%$item.page_title%></a>
</li>
<%/foreach%>
</ol>
</nav>
</body>
</html>
