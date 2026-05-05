<?php
namespace App\Http\Controllers;

use App\Mail\ApplicationMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        Mail::raw('Тестовое письмо от StepUp!', function ($message) {
            $message->to('maqpal.rus@gmail.com')
                    ->subject('StepUp — тест email');
        });

        return 'Письмо отправлено! Проверь почту.';
    }
}