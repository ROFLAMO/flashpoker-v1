<?php

define('Debug', 'DEBUG');
define('Error', 'ERROR');

/**
 * Logger Class
 *
 * Class managing logs
 *
 * @author Francesco Li Volsi
 * @package Logger
 */
class Logger {

    private static $fd;
    private static $str = "";
    private static $log_filename;
    // object instan
    private static $instance;

    /**
     * Constructor
     * 
     * Init log file to write logs
     *
     * @param string $filename
     */
    private function __construct() {
        if (PKR_DOLOG)
            $this->open();
    }

    /**
     * The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
     * thus eliminating the possibility of duplicate objects.  The methods can be empty, or
     * can contain additional code (most probably generating error messages in response
     * to attempts to call).
     *
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    /**
     * Set FileName log
     *
     * @param string $filename
     */
    public static function setFileLog($filename) {
        self::$log_filename = $filename;
    }

    /**
     * This method must be static, and must return an instance of the object if the object
     * does not already exist.
     *
     */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Open
     * 
     * Open File Descriptor
     */
    public function open() {
        if (is_readable(self::$log_filename))
            self::$fd = @fopen(self::$log_filename, "a");
        else
            self::$fd = @fopen(self::$log_filename, "w");
    }

    /**
     * Close
     * 
     * Close File Descriptor
     */
    public function close() {
        if (self::$fd)
            @fclose(self::$fd);
    }

    /**
     * log
     * 
     * Write data log on file
     *
     * @param string $state
     * @param string $val1
     * @param string $val2
     * @param string $val3
     * @param string $msg
     */
    public function log($state, $val1 = "", $val2 = "", $val3 = "", $msg) {
        // append date/time to message		
        self::$str = date("d-m-y h:i:s") . " " . $_SERVER['REQUEST_TIME'] . " [" . $state . "] ";

        if (!empty($val1))
            self::$str .= "[" . $val1 . "] ";
        if (!empty($val2))
            self::$str .= "[" . $val2 . "] ";
        if (!empty($val3))
            self::$str .= "[" . $val3 . "] ";

        self::$str .= $msg;

        //flock($this->fd, LOCK_EX);
        @fwrite(self::$fd, "\r\n" . self::$str);
        //flock($this->fd, LOCK_UN);
    }

}

?>