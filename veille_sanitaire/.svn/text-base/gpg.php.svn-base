<?php
    $gpg = '/usr/local/bin/gpg';
    $switches = ' --always-trust -a --batch --no-tty';
    $recipient = 'some@pgp_user.com';
    $command = "$gpg $switches -e -r $recipient";
print($command);
    // take in the plain text data
    $message = $_GET['plain'];

    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin is a pipe that the child will read from
        1 => array("pipe", "w"), // stdout is a pipe that the child will write to
        2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
    );

    putenv("GNUPGHOME=/var/www/.gnupg");
    $process = proc_open($command, $descriptorspec, $pipes);
    if (is_resource($process)) {
        // $pipes now looks like this:
        // 0 => writeable handle connected to child stdin
        // 1 => readable handle connected to child stdout
        // Any error output will be appended to /tmp/error-output.txt

        fwrite($pipes[0], $message);
        fclose($pipes[0]);

        while (!feof($pipes[1])) {
            $encrypted_message .= fgets($pipes[1], 1024);
        }
        fclose($pipes[1]);

        // It is important that you close any pipes before calling
        // proc_close in order to avoid a deadlock
        $return_value = proc_close($process);
    }

    $_GET['crypted'] = $encrypted_message;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1?>
<title>GPG Proof of concept page.</title>
</head>

<body>
    <form name="form1 method="GET" action="gpg.php">
    <p>Plaintext Data:</p>
    <p>
    <textarea name="plain" cols="80 rows="15 id="plain"><?php echo $_GET['plain']; ?></textarea>
    </p>
    <p>
    <input type="submit" name="Submit" value="Encrypt">
    </p>
    <p>Encrypted Data (will always appear, even if blank input): </p>
    <p>
    <textarea name="crypted_display" cols="80 rows="15 id="crypted_display"><?php echo $_GET['crypted']; ?></textarea>
    </p>
    <input name="crypted" type="hidden" id="crypted">
    </form>
</body>
</html>