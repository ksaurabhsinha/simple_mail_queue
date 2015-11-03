# simple_mail_queue
This is a simple implementation of a mail_queue. We need to have a Database table for the same which will have rows
corresponding to the emails to be sent. This implementation uses SWIFTMailer to send SMTP emails.

# Notice

1. Install the dependencies from composer
2. Update the proper configuration for the SMTP, DATABASE and Async Location in /config.php
3. Make sure /applogs/ is a writable folder with proper permissions
4. Import the SQL schema + data from  /sql/mail_queue.sql

In case of any other issue, please contact sinha.ksaurabh@gmail.com
