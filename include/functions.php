<?php
// This is the mailer's functions.php
    // simple logging function if user has writing permission in the log directory
    function fileLog($message, $stampStart, $stampEnd) { // $stampStart + $stampEnd = booleans requiring to print prefix and suffix to the log (see below)
        // if verbose is not true => don't allow debug logs
        if (!$GLOBALS['verbose']) {return;}

        $fh = fopen("../logs/mailerlog.txt", "a");

        // if required by $stampStart => print a prefix with date and time
        if ($stampStart) {fwrite($fh, date("Y/m/d H:i:s\n"));}

        fwrite($fh, $message);

        // if required by $stampEnd => print a suffix with 2 new lines
        if ($stampEnd) {fwrite($fh, "\n\n");}

        fclose($fh);
    }
?>