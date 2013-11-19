<?xml version="1.0" encoding="UTF-8"?>
<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1">
  <head>
    <meta name="dtb:uid" content="<%$book_id%>"/>
    <meta name="dtb:depth" content="1"/>
    <meta name="dtb:totalPageCount" content="0"/>
    <meta name="dtb:maxPageNumber" content="0"/>
  </head>
  <docTitle>
    <text><%$novel_title%></text>
  </docTitle>
  <navMap>

<%foreach from=$page_header item=item name=page_header key=key%>
    <navPoint id="<%$item.page_id%>" playOrder="<%$item.page_order+1%>">
      <navLabel>
        <text><%$item.page_title%></text>
      </navLabel>
      <content src="<%$item.page_path%>"/>
    </navPoint>
<%/foreach%>
  </navMap>
</ncx>