<?php namespace App\Helpers;

/**
 * Interacts with the application configuration.
 * @package App\Helpers
 * @author Marcus T <marcust261@icloud.com>
 * @since 04.04.15
 */
class Config {

    /**
     * The file extension that is used for configuration files.
     */
    const FILE_EXTENSION = '.ini';

    /**
     * Gets the configuration details for a particular aspect of the application.
     * @param string $name The application section file name. For example, for database
     *              configuration, the file name is "db.ini" and hence the
     *              name supplied should be "db".
     * @param string|NULL $section The section of the configuration file which
     *              should be retrieved. Default is NULL and hence returns
     *              the entire configuration file contents.
     * @return array An associative array containing the configuration settings.
     */
    public static function get($name, $section = NULL)
    {
        $split_by_sections = is_null($section) ? FALSE : TRUE;
        $settings =  parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/../config/$name" . self::FILE_EXTENSION, $split_by_sections);
        return is_null($section) ? $settings : $settings[$section];
    }

}