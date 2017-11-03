<?php

/**
 * Fetch and return URL for the Photo of The Day in Wikimedia Commons
 *
 * Usage:
 * ```
 * $wikimediaCommonsPotd = new WikimediaCommonsPotd();
 * echo $wikimediaCommonsPotd->get( 1024 );
 * ```
 *
 * @link https://commons.wikimedia.org/wiki/Commons:Picture_of_the_day
 */
class WikimediaCommonsPotd {
  // https://commons.wikimedia.org/wiki/File:Saffron_finch_(Sicalis_flaveola)_male.JPG
  public static $default_image = 'Saffron_finch_(Sicalis_flaveola)_male.JPG';

  private static $default_image_width = '1200'; // in Pixels
  private static $wiki_url = 'https://commons.wikimedia.org/';
  private static $wiki_api_url = 'w/api.php';
  private static $wiki_filepath_url = 'wiki/Special:FilePath/';

  /**
   * Attempts to get and parse picture of the day response from wiki API
   *
   * @return mixed Returns URL string on success, otherwise false
   */
  private static function fetchImageAPI() {
    $api_query_params = http_build_query( array(
      'action'       => 'parse',
      'text'         => '{{Potd}}',
      'contentmodel' => 'wikitext',
      'prop'         => 'images',
      'format'       => 'json',
    ) );

    $api_url =
      self::$wiki_url .
      self::$wiki_api_url .
      '?' . $api_query_params;

    $api_result = file_get_contents( $api_url );

    if ( empty( $api_result ) ) {
      return false;
    }

    $json = json_decode( $api_result );

    if ( empty( $json ) ||
         !isset( $json->parse ) ||
         !isset( $json->parse->images ) ||
         !isset( $json->parse->images[0] )
    ) {
      return false;
    }

    return (string) $json->parse->images[0];
  }

  /**
   * Get default picture URL
   *
   * @param int Width of the image in pixels
   * @return string URL
   */
  private static function getDefaultImage( $width ) {
    return
      self::$wiki_url .
      self::$wiki_filepath_url .
      self::$default_image .
      '?width=' . $width;
  }

  /**
   * Get picture of the day
   *
   * @param int Width of the image in pixels
   * @return string URL
   */
  public static function get( $width ) {
    $width = !empty( $width ) ? intval( $width ) : self::$default_image_width;

    $image_name = self::fetchImageAPI();

    if ( ! $image_name ) {
      return self::getDefaultImage( $width );
    }

    return self::$wiki_url . self::$wiki_filepath_url . $image_name . '?width=' . $width;
  }
}
