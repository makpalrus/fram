<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class DemoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;   

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        return $this
            ->from('admin@stepup.com', 'StepUp Platform')
            ->subject('Новый отклик на вашу вакансию')
            ->view('mails.demo');  
    }
}
