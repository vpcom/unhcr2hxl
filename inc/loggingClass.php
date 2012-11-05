<?php
/** 
 * Logging class:
 * - contains lfile, lwrite and lclose public methods
 * - lfile sets path and name of log file
 * - lwrite writes message to the log file (and implicitly opens log file)
 * - lclose closes log file
 * - first call of lwrite method will open log file implicitly
 * - message is written with the following format: [d/M/Y:H:i:s] (script name) message
 */

class Logging
{
    // declare log file and file pointer as private properties
    private $log_file, $fp;
    // set log file (path and name)
    public function file($path)
    {
        $this->log_file = $path;
    }

    /*
    * Writes the message to the log file.
    */
    public function write($message)
    {
        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->open();
        }

        $script_name = $_SERVER["SCRIPT_NAME"];  // pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        // define current time and suppress E_WARNING if using the system TZ settings
        // (don't forget to set the INI setting date.timezone)
        $time = @date('[d/M/Y:H:i:s]');
        // write current time, script name and message to the log file
        fwrite($this->fp, "$time ($script_name) $message" . PHP_EOL);
    }

    /*
    * Closes the log file.
    */
    public function close()
    {
        fclose($this->fp);
    }

    /*
    * Opens log file, create if necessary.
    */
    private function open()
    {
        $file = $this->log_file;
        $this->fp = fopen($file, 'a') or exit("Can't open $file!");
    }
}

?>