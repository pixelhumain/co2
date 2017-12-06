<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php 
foreach ($list as $key => $value) {
?>
  <url>
    <loc>http://communecter.org/#<?php echo $value["name"]?></loc>
  </url>
<?php 
   }
?>
</urlset>
