<?xml version="1.0" encoding="UTF-8"?>
<package version="3.0" xmlns="http://www.idpf.org/2007/opf"
         unique-identifier="BookId">
 <metadata xmlns:dc="http://purl.org/dc/elements/1.1/"
           xmlns:dcterms="http://purl.org/dc/terms/">
   <dc:identifier id="BookId"><%$book_id%></dc:identifier>
   <dc:date>2009-09-18T00:00:00Z</dc:date><!-- publish date -->
   <meta property="dcterms:modified">2012-08-08T00:00:00Z</meta><!-- revision date -->
   <dc:title><%$novel_title%></dc:title>
   <dc:contributor><%$author%></dc:contributor><!-- as original author -->
   <dc:creator>nyanpass novel</dc:creator><!-- as an editor of this book -->
   <dc:language>ja</dc:language>
   <dc:rights>Public Domain</dc:rights>
   <dc:publisher><%$composer%></dc:publisher>
   <!-- <meta property="page-progression-direction">rtl</meta> --><!-- obsolete way -->
 </metadata>
 <manifest>
  <item properties="nav" media-type="application/xhtml+xml" id="navdoc" href="navdoc.html"/><!-- 3.0 toc -->
  <item id="tocncx" href="toc.ncx" media-type="application/x-dtbncx+xml" /><!-- 2.0 toc -->
  <item id="style" href="stylesheet.css" media-type="text/css" />
<%foreach from=$page_header item=item name=page_header key=key%>
  <item id="<%$item.page_id%>" href="<%$item.page_path%>" media-type="application/xhtml+xml" />
<%/foreach%>
 </manifest>
 <spine toc="tocncx" page-progression-direction="rtl"><!-- recommended new way -->
<%foreach from=$page_header item=item name=page_header key=key%>
  <itemref idref="<%$item.page_id%>" />
<%/foreach%>
 </spine>
</package>
