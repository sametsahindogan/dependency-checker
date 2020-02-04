<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class NotificationMailJob
 * @package App\Jobs
 */
class NotificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $to */
    private $to;

    /** @var string $text */
    private $text;

    /**
     * NotificationMailJob constructor.
     * @param string $repositoryUrl
     * @param array $to
     * @param string $text
     */
    public function __construct(array $to, string $text)
    {
        $this->to = $to;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->to as $address){
            try {
                $mail = new PHPMailer(1);
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Host = null;
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true));
                $mail->SMTPSecure = 'tls';
                $mail->Username = null;
                $mail->Password = null;
                $mail->setFrom(null, null);
                $mail->addReplyTo(null, null);
                $mail->addAddress($address);
                $mail->Subject = 'Notification E-Mail';
                $mail->msgHTML($this->text);
//                $mail->send();

            } catch (\Exception $exception) {
                Log::channel('mail')->info($exception->getMessage());
            }
        }

    }
}
