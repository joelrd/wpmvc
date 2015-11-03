<?php

namespace Amostajo\WPPluginCore;

use Katzgrau\KLogger\Logger;
use Amostajo\WPPluginCore\Config;
use Amostajo\WPPluginCore\Contracts\Loggable;

/**
 * Log class.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @package Amostajo\WPPluginCore
 * @version 1.0
 */
class Log implements Loggable
{
	/**
	 * Fast cache class engine.
	 */
	protected static $logger;

	/**
	 * Default constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public function __construct( Config $config )
	{
		if ( ! isset( self::$logger )
			&& $config->get( 'log' )
		) {
			// Create folder
			if ( ! is_dir( $config->get( 'log.path' ) ) ) {
				mkdir( $config->get( 'log.path' ), 0777, true );
			}
			// Init logger
			self::$logger = new Logger( $config->get( 'log.path' ) );
		}
	}

	/**
	 * Static constructor.
	 * @since 1.0
	 * @param array $config Config settings.
	 */
	public static function init( Config $config )
	{
		new self( $config );
	}

	/**
	 * Returns Logger instance.
	 * @since 1.0
	 * @return mixed.
	 */
	public static function instance()
	{
		return isset( self::$logger ) ? self::$logger : false;
	}

	/**
	 * Prints message information in log.
	 * @since 1.0
	 * @param string $message Message information to display in log.
	 */
	public static function info( $message )
	{
		$logger = self::instance();
		if ( $logger ) {
			$logger->info( $message );
		}
	}

	/**
	 * Debugs / prints value in log.
	 * @since 1.0
	 * @param mixed $message Message to debug.
	 * @param array $values  Value(s) to debug.
	 */
	public static function debug( $message, $values = [] )
	{
		$logger = self::instance();
		if ( $logger ) {
			$logger->debug( $message, $values );
		}
	}

	/**
	 * Prints error log.
	 * @since 1.0
	 * @param mixed $e Exception / error.
	 */
	public static function error( $e )
	{
		$logger = self::instance();
		if ( $logger ) {
			$logger->error( $e );
		}
	}
}
