# Wikimedia Commons Picture Of The Day URL
Get URL for today's [Wikimedia Commons picture of the day](https://commons.wikimedia.org/wiki/Commons:Picture_of_the_day).

Utilises great Wikimedia Commons' [Redirect/file tool](https://commons.wikimedia.org/wiki/Special:Redirect/file).

Usage:
```php
require_once( 'wikimedia_commons_potd.class.php' );

$wikimediaCommonsPotd = new WikimediaCommonsPotd();

echo $wikimediaCommonsPotd->get( 1024 );

// → https://commons.wikimedia.org/wiki/Special:FilePath/Wien_Zentralfriedhof_Kirche_Innenraum_SO-Seite_01.jpg?width=1024
```

Please remember that this won't cache anything and that you should [link back](https://commons.wikimedia.org/wiki/Commons:Reusing_content_outside_Wikimedia) to awesome Wikimedia folks when using their content.

# License
MIT
